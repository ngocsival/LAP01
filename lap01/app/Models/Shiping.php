<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shiping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'shipping_name',
        'customer_id',
        'shipping_address',
        'shipping_email',
        'shipping_phone',
        'shipping_note',
        'shipping_method',
    ];
    protected $primaryKey = 'shipping_id';
    protected $table = 'tbl_shiping';
}
