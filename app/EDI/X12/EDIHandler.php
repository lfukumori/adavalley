<?php 

namespace EDI\X12;

use EDI\X12\Mapper;
use EDI\X12\Documents\PurchaseOrder;
use ERP\Orders\SalesOrder;

class EDIHandler
{
    private $ediDocument;
    private $erpOrder;
    private $FA997;
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function load(PurchaseOrder $ediDocument)
    {
        $this->ediDocument = $ediDocument;

        $this->buildERP();
        $this->buildFA997();
    }

    public function getDocument()
    {
        return $this->ediDocument;
    }

    
    public function getOriginalMessage()
    {
        return $this->ediDocument->__toString();
    }
    
    private function buildERP()
    {
        $this->erpOrder = SalesOrder::fromDocument($this->ediDocument);

        return $this;
    }

    public function saveERP()
    {
        try {
            $this->erpOrder->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function buildFA997()
    {
        
        foreach ($map->getMap() as $keyword => $method) {
            $this->template = str_replace($keyword, $this->ediDocument->$method(), $this->template);
        }

        return preg_replace("/\r|\n/", "", $this->template);
        $this->acknowledgment = FA997::fromDocument($this->ediDocument);

        return $this;
    }

    public function saveAcknowledgement()
    {
        try {
            if ($this->ediDocument->processed) {
                Storage::disk('edi')->put(
                    "{$this->ediDocument->as2Id}/test/997-{$this->ediDocument->poNumber()}.txt",
                    $this->acknowledgment
                );

                $this->ediDocument->filePath = "{$this->ediDocument->as2Id}/test/997-{$this->ediDocument->poNumber()}.txt";

                return true;
            }

            Storage::disk('edi')->put(
                "{$this->ediDocument->as2Id}/incoming/error/997-{$this->ediDocument->poNumber()}.txt",
                $this->translate()
            );

            $this->ediDocument->filePath = "{$this->ediDocument->as2Id}/incoming/error/997-{$this->ediDocument->poNumber()}.txt";

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}