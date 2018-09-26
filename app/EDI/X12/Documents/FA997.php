<?php

namespace EDI\X12\Documents;

use EDI\X12\Maps\FA977Success;
use EDI\X12\Maps\FA977Error;

class FA997
{
    public function __construct($segments, $filePath)
    {
        parent::__construct($segments, $filePath);
    }

    public function isaSenderQualifier()
    {
        return $this->segments['ISA'][0][4];
    }

    public function isaSenderId()
    {
        return $this->segments['ISA'][0][5];
    }

    public function isaReceiverQualifier()
    {
        return $this->segments['ISA'][0][6];
    }

    public function isaReceiverId()
    {
        return $this->segments['ISA'][0][7];
    }

    public function shortDate()
    {
        return $this->dateTime->format('ymd');
    }

    public function shortTime()
    {
        return $this->dateTime->format('Hi');
    }

    public function gsControlNumber()
    {          
        $this->gsControlNumber = $this->getNewIsaControlNumberShort() + $this->gsControlNumberCount;
        $this->gsControlNumberCount++;

        return $this->gsControlNumber;
    }
    
    public function stControlNumber()
    {
        $this->stControlNumber = str_pad($this->stControlNumberCount, 3, "0", STR_PAD_LEFT);
        $this->stControlNumberCount++;
        
        return "{$this->gsControlNumber()}{$this->stControlNumber}";
    }

    public function gsSenderId()
    {
        return trim($this->isaSenderId());
    }

    public function gsReceiverId()
    {
        return trim($this->isaReceiverId());
    }

    public function longDate()
    {
        return $this->dateTime->format('Ymd');
    }

    public function functionalIdCode()
    {
        return $this->segments['GS'][0][0];
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

    public function toArray()
    {
        return [
            'customer_id'   => $this->customerId(),
            'order_date'    => $this->orderDate(),
            'expected_date' => $this->expectedDate(),
            'po_number'     => $this->poNumber(),
            'ship_to_id'    => $this->shipToId(),
            'items'         => $this->items(),
            'date_time'      => $this->dateTime
        ];
    }

    public function customerId()
    {
        $customers = [
            '9258350000' => 920
        ];

        return $customers[trim($this->isaSenderId())];
    }

    public function filePath()
    {
        return "{$this->getAs2Id()}/incoming/";
    }

    public function fileName()
    {
        return "{$this->transactionType()}-{$this->poNumber()}.txt";
    }

    public function includedTransactionSets()
    {
        return $this->stControlNumberCount - 1;
    }

    public function receivedTransactionSets()
    {
        return $this->stControlNumberCount - 1;
    }

    public function acceptedTransactionSets()
    {
        return $this->stControlNumberCount - 1;
    }

    public function getAs2Id()
    {
        return 'spartannash';
    }
}