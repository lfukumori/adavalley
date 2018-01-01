<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function store()
    {
        $this->delete();
    }
}
