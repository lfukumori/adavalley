<?php

namespace EDI\X12;

use EDI\X12\Map;
use EDI\X12\Documents\PurchaseOrder;
use Illuminate\Support\Facades\Storage;

class Mapper
{
    private $map;
    private $document;
    private $template;

    public function __construct(PurchaseOrder $document = null)
    {
        $this->document = $document;
        $this->template = Storage::get('997-template.txt');
    }

    public function setDocument(Document $document)
    {
        $this->document = $document;
    }

    public function setMap(Map $map)
    {
        $this->map = $map;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function translate($from, $to)
    {
        foreach ($this->map->getMap() as $keyword => $method) {
            $this->template = str_replace($keyword, $this->document->$method(), $this->template);
        }

        return preg_replace("/\r|\n/", "", $this->template);
    }

    public function send()
    {
        try {
            if ($this->document->processed) {
                Storage::disk('edi')->put(
                    "{$this->document->as2Id}/test/997-{$this->document->poNumber()}.txt", 
                    $this->translate()
                );

                $this->document->filePath = "{$this->document->as2Id}/test/997-{$this->document->poNumber()}.txt";

                return true;
            }

            Storage::disk('edi')->put(
                "{$this->document->as2Id}/incoming/error/997-{$this->document->poNumber()}.txt",
                $this->translate()
            );

            $this->document->filePath = "{$this->document->as2Id}/incoming/error/997-{$this->document->poNumber()}.txt";

            return true;
        } catch (\Exception $e) {
            return false;
        }
        
    }
}
