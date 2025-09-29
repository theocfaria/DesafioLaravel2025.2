<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Representa um pedido no sistema.
 *
 * @property int
 * @property string 
 * @property int 
 * @property int 
 * @property float 
 * @property string 
 * @property string|null 
 * @property \Illuminate\Support\Carbon 
 * @property \Illuminate\Support\Carbon 
 *
 * @property-read \App\Models\User
 * @property-read \App\Models\User
 */
class Order extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_id',
        'user_id',
        'seller_id',
        'total_amount',
        'status',
        'pagseguro_order_id',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2', 
    ];

    /**
     * Define o relacionamento com o usuário que fez a compra (comprador).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Define o relacionamento com o usuário que fez a venda (vendedor/anunciante).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'user_id');
    }
}