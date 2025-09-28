<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $primaryKey = 'sale_id';

    protected $fillable = [
        'user_id',  
        'seller_id',
        'total_value',
        'status',
        'pagseguro_transaction_code', 
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product', 'sale_id', 'product_id', 'sale_id', 'product_id')
            ->withPivot('quantity', 'price_at_sale')
            ->withTimestamps();
    }
}