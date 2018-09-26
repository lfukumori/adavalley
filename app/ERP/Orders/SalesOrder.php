<?php 

namespace ERP\Orders;

use EDI\X12\Documents\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use EDI\X12\Documents\FA997;

class SalesOrder
{
    private $id;
    private $customer_id;
    private $order_date;
    private $expected_date;
    private $po_number;
    private $ship_to_id;
    private $status = "P";
    private $total = 0;
    private $items;
    private $date_time;
    private $item_master;
    protected $connection = 'av_test';

    private function __construct(Array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public static function fromDocument(PurchaseOrder $document)
    {
        return new self($document->toArray());
    }

    public function save()
    {
        try {
            $this->saveOrderHeader();

            $this->items->each(function ($item) {
                $this->saveOrderDetail($item);
            });

            return true;
        } catch (\Exception $e) {
            if ($this->id > 0) {
                DB::connection($this->connection)->delete("DELETE FROM order_header WHERE id = {$this->id}");
            }
            
            return false;
        }
    }

    private function saveOrderHeader()
    {
        try {
            $this->id = DB::connection($this->connection)->table('order_header')->insertGetId([
                'PONBR'                 => $this->po_number,
                'customer_id'           => $this->customer_id,
                'order_date'            => $this->order_date,
                'ship_date'             => $this->expected_date,
                'status'                => $this->status,
                'ship_to_id'            => $this->ship_to_id,
                'total_weight_invoiced' => $this->total,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        } 
    }

    private function saveOrderDetail($item)
    {
        try {
            $this->item_master = $this->getItemMaster($item->identifier);
            $item->netweight = $this->getNetWeight($item->quantity);
            $item->price = $this->getPrice();

            DB::connection($this->connection)->table('order_detail')->insert([
                'order_id'              => $this->id,
                'ITEM'                  => $this->item_master->item_number,
                'item_master_id'        => $this->item_master->id, 
                'QNTY'                  => $item->quantity,
                'PRICE'                 => $item->price,
                'NETWEIGHT'             => $item->netweight,
                'actual_cases_invoiced' => 0,
                'DATE'                  => $this->date_time->format('Ymd'),
                'pack_size'             => $this->item_master->pack_size,
                'CASEPOINTS'            => number_format($item->quantity, 2, ".", ""),
                'AMOUNT'                => number_format($item->netweight * $item->price, 2, ".", ""),
                'total_weight'          => $item->netweight + ($this->item_master->master_pack_tare_lbs * $item->quantity),
            ]);

            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        };
    }

    private function getItemMaster($identifier)
    {
        try {
            return DB::connection($this->connection)->select(
                "SELECT 
                    id, 
                    item_number, 
                    issue_unites_per_perchase_units, 
                    master_pack_finished_lbs, 
                    master_pack_tare_lbs, 
                    repack_charge, 
                    price_type, 
                    cost_standard, 
                    pack_size 
                FROM item_master 
                WHERE serial_item 
                LIKE '%{$identifier}%' 
                AND active = 1 
                ORDER BY id DESC 
                LIMIT 1"
            )[0];
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getNetWeight($quantity)
    {
        if ($this->item_master->issue_unites_per_perchase_units > 1) {
            return ($this->item_master->master_pack_finished_lbs / $this->item_master->issue_unites_per_perchase_units) * $quantity;
        }
        
        return $this->item_master->master_pack_finished_lbs * $quantity;             
    }

    private function getPrice()
    {
        if ($this->customer_id == 920 && $this->item_master->item_number == '66053') {
            return 7.65;
        }
        
        return $this->getItemPrice() ?? 0.00;
    }

    private function getItemPrice()
    {
        try {
            $price = $this->getItemPriceByItem();

            if ($price == 0) {
                $price = $this->getItemPriceByAccount($this->getAccountNumber());
            }

            if ($price == 0) {
                $this->item_master->master_pack_finished_lbs = 0;
                $this->item_master->price_type               = $this->item_master->price_type ?? "A";
                $this->item_master->cost_standard            = $this->item_master->cost_standard ?? 0;

                $price = $this->getPriceFromItemMaster();
            }

            if ($price == 0) {
                $this->sendMail(
                    "EDI Item Price Error",
                    "Could not get price for item # {$this->item_master->item_number} on sales order # {$this->id}.  Please manually add a price."
                );
            }

            return number_format($price, 2, ".", "");
        } catch (\Exception $e) {
            return false;
        }
    }

    private function getAccountNumber()
    {
        return DB::connection($this->connection)->select(
            "SELECT account_number 
            FROM customer 
            WHERE id = {$this->customer_id}"
        )[0]->account_number ?? 0;
    }

    private function getItemPriceByItem()
    {
        return DB::connection($this->connection)->select(
            "SELECT price 
            FROM item_price 
            WHERE item_master_id = $this->item_master->id 
            AND customer_id = $this->customer_id 
            AND active_date <= {$this->order_date} 
            AND deleted = 0 
            AND price > 0 
            ORDER BY active_date DESC, id DESC 
            LIMIT 1"
        )[0]->price ?? 0;
    }

    private function getItemPriceByAccount($account)
    {
        return DB::connection($this->connection)->select(
            "SELECT price 
            FROM item_price 
            WHERE item_master_id = $this->item_master->id 
            AND account_number = $account  
            AND deleted = 0 
            AND price > 0
            ORDER BY active_date DESC, id DESC 
            LIMIT 1"
        )[0]->price ?? 0;
    }

    private function getPriceFromItemMaster()
    {
        if ($this->item_master->issue_unites_per_perchase_units > 1) {
            return ($this->getPriceMarkUp() + $this->item_master->repack_charge) + ($this->item_master->cost_standard / $this->item_master->issue_unites_per_perchase_units);
        }

        return ($this->getPriceMarkUp() + $this->item_master->repack_charge) + $this->item_master->cost_standard;
    }

    private function getPriceMarkUp()
    {
        $priceLevel = $this->getPriceLevel();

        return DB::connection($this->connection)->select(
            "SELECT Rate 
                    FROM markup
                    WHERE price_level = $priceLevel  
                    AND type LIKE '{$this->item_master->price_type}'"
        )[0]->markup ?? 0;
    }

    private function getPriceLevel()
    {
        return DB::connection($this->connection)->select(
            "SELECT price_level 
            FROM customer 
            WHERE id = {$this->customer_id}"
        )[0]->price_level ?? 1;
    }

    private function sendEmail($subject, $body)
    {
        Mail::send('emails.alert-brian', ['error' => $body], function ($message) use ($subject) {
            $message->from('brian@adavalley.com', $subject);
            $message->to('bdbriandupont@gmail.com');
        });
    }
}