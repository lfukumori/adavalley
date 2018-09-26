<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use EDI\X12\Parser;
use ERP\Orders\SalesOrder;

class DocumentTest extends TestCase
{
    /** 
     * A Document can build a sales order from a 850 message.
     * 
     * A sales order holds all needed data form importing into the ERP database.
     */
    public function testBuildErpOrder()
    {
        $parsedDocument = collect(Parser::parse(Storage::get('spartan850test.txt')))->first();
      
        $this->assertInstanceOf(SalesOrder::class, $parsedDocument->buildErpOrder());
    }
}