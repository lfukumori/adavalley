<?php

namespace EDI\X12\Documents;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PO850 
{
    private $segments = [];
    private $isaControlNumber;
    private $newIsaControlNumber;
    public $dateTime;
    public $as2Id;
    public $filePath;
    public $fileName;
    public $processed;

    public function __construct($segments, $filePath)
    {
        foreach ($segments as $segment) {
            $id = array_shift($segment);

            if (!array_key_exists($id, $this->segments)) {
                $this->segments[$id] = [];
            }

            $this->segments[$id][] = $segment;
        }

        $this->dateTime = Carbon::now();
        $this->isaControlNumber = $this->isaControlNumber();
        $this->as2Id = $this->getAs2Id();
        $this->setNewIsaControlNumber();
        $this->filePath = $filePath;
        $this->setFileName();
        $this->processed = false;
    }

    public function isaSenderId()
    {
        return $this->segments['ISA'][0][5];
    }

    public function isaControlNumber()
    {
        return $this->segments['ISA'][0][12];
    }

    public function orderDate()
    {
        return (new \DateTime($this->segments['BEG'][0][4]))->format('Y-m-d');
    }

    public function expectedDate()
    {
        return (new \DateTime($this->segments['DTM'][0][1]))->format('Y-m-d');
    }

    public function transactionType()
    {
        return trim($this->segments['ST'][0][0]);
    }

    public function poNumber()
    {
        return trim($this->segments['BEG'][0][2]);
    }

    public function shipToId()
    {
        return 2;
    }

    public function items()
    {
        $items = collect();
        $index = 0;

        $po1 = $this->segments['PO1'];
        $pid = $this->segments['PID'];
        $po4 = $this->segments['PO4'];

        foreach ($po1 as $element) {
            $item = (object)[
                'quantity'          => $element[1],
                'unitType'          => $element[2],
                'price'             => $element[3],
                'identifierCode'    => $element[5],
                'identifier'        => $element[6],
                'qualifierCode'     => $element[9],
                'qualifier'         => $element[10],
                'description'       => $pid[$index][4],
                'packSize'          => $po4[$index][0],
                'netweight'         => null,
            ];

            $items->push($item);

            $index++;
        }

        return $items;
    }

    public function collect()
    {
        return collect([
            'customer_id' => $this->customerId(),
            'order_date' => $this->orderDate(),
            'expected_date' => $this->expectedDate(),
            'po_number' => $this->poNumber(),
            'ship_to_id' => $this->shipToId(),
            'items' => $this->items(),
            'date_time' => $this->dateTime
        ]);
    }

    public function customerId()
    {
        $customers = [
            '9258350000' => 920
        ];

        return $customers[trim($this->isaSenderId())];
    }

    public function getAs2Id()
    {
        return 'spartannash';
    }

    private function setNewIsaControlNumber()
    {
        if (empty($this->newIsaControlNumber)) {
            $number = DB::select('SELECT MAX(control_number) as control_number FROM edi_outgoing');

            if (count($number) > 0) {
                $number = $number[0]->control_number + 1;
            } else {
                $number = 1;
            }

            $this->newIsaControlNumber = str_pad($number, 9, "0", STR_PAD_LEFT);
        }
    }

    private function setFileName()
    {
        $pathArray = explode('/', $this->filePath);

        $this->fileName = array_pop($pathArray);
    }
}