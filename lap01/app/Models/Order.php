<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'shipping_id',
        'customer_id',
        'order_status',
        'order_code',
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';
}
