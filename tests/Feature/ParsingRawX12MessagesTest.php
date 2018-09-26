<?php

namespace Tests\Feature;

use EDI\X12\Parser;
use ERP\Orders\SalesOrder;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ParsingRawX12MessagesTest extends TestCase
{
    /** @test */
    public function it_can_parse_a_X12_message_into_a_array_of_documents()
    {
        // Given we have a message;
        $message = Storage::get('spartan850test.txt');

        // When we parse it 
        $documents = Parser::parse($message);

        // Then we should have an array of Documents
        $this->assertTrue(is_array($documents));
        $this->assertCount(1, $documents);
    }

    /** @test */
    // public function it_can_save_an_edi_document_into_adavalley_database_as_an_sales_order()
    // {
    //     $salesOrder = collect(Parser::parse(Storage::get('edi-messages/spartannash/850/088283.txt')))->first()->buildErpOrder();

    //     if (DB::connection('av_production')->insert(
    //         "insert into order_header (PONBR, customer_id, order_date, ship_date, status, ship_to_id, total_weight_invoiced) values (?, ?, ?, ?, ?, ?, ?)", 
    //         [$salesOrder->po_number, $salesOrder->customer, $salesOrder->order_date, $salesOrder->expected_date, $salesOrder->status, $salesOrder->ship_to, $salesOrder->total]
    //     )) {
    //         $orderId = DB::connection('av_production')
    //                         ->select("SELECT id FROM order_header WHERE customer_id = $salesOrder->customer ORDER BY id DESC LIMIT 1")
    //                         [0]->id;

    //         $salesOrder->id = $orderId;

    //         // curl items to avg erp functions/insert_edi_sales_order.php
    //         $ch = curl_init("http://192.168.1.10/functions/insert_edi_sales_order.php");
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt(
    //             $ch,
    //             CURLOPT_POSTFIELDS,
    //             [
    //                 'items' => json_encode($salesOrder->items),
    //                 'customer_id' => $salesOrder->customer,
    //                 'order_id' => $orderId
    //             ]
    //         );
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_HEADER, 0);

    //         $success = curl_exec($ch);

    //         curl_close($ch);

    //         if (!$success) {
    //             Mail::send('emails.alert-brian', ['error' => 'Error adding items to ERP sales order.'], function ($message) {
    //                 $message->from('brian@adavalley.com', 'Brian DuPont');
    //                 $message->to('bdbriandupont@gmail.com');
    //                 $message->subject('EDI CURL Error');
    //             });
    //         }
    //     } else {
    //         Mail::send('emails.alert-brian', ['error' => 'Error adding EDI order to ERP system.'], function ($message) {
    //             $message->from('brian@adavalley.com', 'Brian DuPont');
    //             $message->to('bdbriandupont@gmail.com');
    //             $message->subject('EDI Database Error');
    //         });
    //     }

    //     // Then we should have an order_header and order_detail in av_production database
    //     $itemNumber = DB::connection('av_production')->select("SELECT ITEM FROM order_detail WHERE order_id = {$salesOrder->id}");
    //     $customer_id = DB::connection('av_production')->select("SELECT customer_id FROM order_header WHERE id = {$salesOrder->id}");

    //     $itemNumber = $itemNumber[0]->ITEM;
    //     $customer_id = $customer_id[0]->customer_id;
        
    //     $this->assertEquals($salesOrder->customer, $customer_id);
    //     $this->assertEquals('66053', $itemNumber);
    // }
}