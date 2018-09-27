<?php 

namespace EDI\X12;

use EDI\X12\Mapper;
use EDI\X12\Documents\PO850;
use EDI\X12\Documents\FA997;
use ERP\Orders\SalesOrder;

class IncomingHandler
{
    private $PO850;
    private $FA997;
    private $mapper;
    private $salesOrder;

    public function __construct()
    {
        $this->FA997 = new FA997();
        $this->mapper = new Mapper();
    }

    public function handle()
    {
        $this->buildSalesOrder();
        $this->mapFA997();
    }

    public function setPO850(PO850 $PO850)
    {
        $this->PO850 = $PO850;
    }

    public function getPO850()
    {
        return $this->PO850;
    }
    
    private function buildSalesOrder()
    {
        $this->salesOrder = SalesOrder::fromPO850($this->PO850);

        return $this;
    }

    public function saveSalesOrder()
    {
        try {
            $this->salesOrder->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function mapToFA997()
    {
        $this->mapper->setDocument($this->PO850);

        $this->mapper->map();

        return $this;
    }

    public function saveFA997()
    {
        try {
            if ($this->PO850->processed) {
                Storage::disk('edi')->put(
                    "{$this->PO850->as2Id}/test/997-{$this->PO850->poNumber()}.txt",
                    $this->FA997
                );

                $this->PO850->filePath = "{$this->PO850->as2Id}/test/997-{$this->PO850->poNumber()}.txt";

                return true;
            }

            Storage::disk('edi')->put(
                "{$this->PO850->as2Id}/incoming/error/997-{$this->PO850->poNumber()}.txt",
                $this->translate()
            );

            $this->PO850->filePath = "{$this->PO850->as2Id}/incoming/error/997-{$this->PO850->poNumber()}.txt";

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}