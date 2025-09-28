<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_id',
        'name',
        'image',
        'price',
        'quantity',
        'description',
        'seller_id',
        'category_id',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product', 'product_id', 'sale_id', 'product_id', 'sale_id');
    }
}
