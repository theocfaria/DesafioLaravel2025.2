<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // app/Models/Order.php
    protected $fillable = [
        'reference_id',
        'buyer_id',
        'seller_id',
        'product_id',
        'category_id',
        'quantity',
        'total_amount',
        'status',
        'pagseguro_order_id'
    ];
}
