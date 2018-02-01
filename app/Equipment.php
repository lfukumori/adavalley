<?php

namespace App;

use App\Status;
use App\Department;
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id', 'status_id');
    }

    public function moveToDepartment(Department $department)
    {
        $this->department()->associate($department);
    }
}
