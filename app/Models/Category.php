<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Define o nome da tabela associada ao modelo.
     * Por convenção, o Laravel espera 'categories'.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * A chave primária do modelo.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * Desativa os timestamps para este modelo.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'category_name'
    ];

    /**
     * Obtenha os produtos para a categoria (relação muitos-para-muitos).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}