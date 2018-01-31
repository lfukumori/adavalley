<?php

namespace App;

use App\Equipment;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}
