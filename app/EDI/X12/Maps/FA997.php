<?php

namespace EDI\X12\Maps;

use App\Map;

class FA997 implements Map 
{
    public function __construct(){}
        
    public function getMap() 
    {
        return collect([
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
        ]);
    }
}
