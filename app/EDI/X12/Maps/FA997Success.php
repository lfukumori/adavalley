<?php

namespace EDI\X12\SpartanNash\Maps;

use App\Map;
use Illuminate\Database\Eloquent\Model;

class FA997Success extends Model implements Map 
{
    private $map = [
        '{{isaSenderQualifier}}'        => 'isaReceiverQualifier',
        '{{isaSenderId}}'               => 'isaReceiverId',
        '{{isaReceiverQualifier}}'      => 'isaSenderQualifier',
        '{{isaReceiverId}}'             => 'isaSenderId',
        '{{shortDate}}'                 => 'shortDate',
        '{{longDate}}'                  => 'longDate',
        '{{shortTime}}'                 => 'shortTime',
        '{{newIsaControlNumber}}'       => 'getNewIsaControlNumber',
        '{{gsSenderId}}'                => 'gsReceiverId',
        '{{gsReceiverId}}'              => 'gsSenderId',
        '{{stControlNumber}}'           => 'stControlNumber',
        '{{gsControlNumber}}'           => 'gsControlNumber',
        '{{functionalIdCode}}'          => 'functionalIdCode',
        '{{poNumber}}'                  => 'poNumber',
        '{{includedTransactionSets}}'   => 'includedTransactionSets',
        '{{receivedTransactionSets}}'   => 'receivedTransactionSets',
        '{{acceptedTransactionSets}}'   => 'acceptedTransactionSets',
    ];

    public function getMap() 
    {
        return $this->map;
    }
}
