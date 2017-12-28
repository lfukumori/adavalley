<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $guarded = [];

    /**
     * The equipments url route path
     * 
     * @return String
     */
    public function path()
    {
        return "/equipment/{$this->id}";
    }
}
