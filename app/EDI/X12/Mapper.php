<?php

namespace EDI\X12;

use EDI\X12\Maps\FA997;
use EDI\X12\Documents\PO850;
use Illuminate\Support\Facades\Storage;

class Mapper
{
    private $map;
    private $document;
    private $template;

    public function __construct()
    {
        $this->map          = $this->setMap(new FA997());
        $this->template     = $this->setTemplate(Storage::get('997-template.txt'));
    }

    public function setDocument(PO850 $document)
    {
        $this->document = $document;
    }

    public function setMap(FA997 $map)
    {
        $this->map = $map;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function map()
    {
        $this->map->getMap()->each(function ($keyword, $method) {
            $this->replace($keyword, $method);
        });

        return preg_replace("/\r|\n/", "", $this->template);
    }

    private function replace($keyword, $replaceWith)
    {
        $this->template = str_replace($keyword, $this->document->$replaceWith(), $this->template);
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
