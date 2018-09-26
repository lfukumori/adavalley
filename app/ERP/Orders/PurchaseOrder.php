<?php 

namespace ERP\Orders;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded = [];
    protected $casts = ['items' => 'array'];
}