<?php

namespace App;

use App\LowTemperature;
use App\HighTemperature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Temperature extends Model
{
    protected $guarded = [];

    /**
     * The lowest and highest acceptable fahrenheit temperatures for rooms.
     *
     * @var array
     */
    protected $ranges = [
        'cooler' => [
            'low' => 30,
            'high' => 40
        ],
        'room6' => [
            'low' => 40,
            'high' => 50
        ],
        'freezer1' => [
            'low' => -10,
            'high' => 10
        ],
        'freezer2' => [
            'low' => -10,
            'high' => 10
        ]
    ];

    /**
     * Determines if the current temperature is inbetween the high and low range.
     *
     * @return boolean
     */
    public function isOutOfRange()
    {
        if ($this->degrees > $this->defaultHigh() || $this->degrees < $this->defaultLow()) {
            return true;
        }

        return false;
    }

    /**
     * Determines if the temperature is high or low.
     *
     * @return string|null
     */
    public function type()
    {
        if ($this->degrees > $this->defaultHigh()) {
            return 'high';
        }

        if ($this->degrees < $this->defaultLow()) {
            return 'low';
        }

        return null;
    }

    /**
     * Retrieves the default high temperature.
     *
     * @return integer
     */
    public function defaultHigh()
    {
        return $this->ranges[$this->room]['high'];
    }

    /**
     * Retrieves the default low temperature.
     *
     * @return integer
     */
    public function defaultLow()
    {
        return $this->ranges[$this->room]['low'];
    }
}
