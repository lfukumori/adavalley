<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    public function getCreatedAtAttribute($value)
    {
        $value->tz = 'America/Detroit';

        return $value;
    }
}
