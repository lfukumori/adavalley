<?php

namespace EDI\X12\Documents;

use Illuminate\Support\Carbon;

class FA997
{
    private $segments = [];
    private $isaControlNumber;
    private $newIsaControlNumber;
    public $dateTime;
    public $as2Id;
    public $filePath;
    public $fileName;
    public $processed;
}