<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference_id',
        'status',
        'product_id',
        'seller_id',
        'category_id',
        'buyer_id',
        'quantity',
        'total_price'
    ];
}
