<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserFunction;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'cep',
    'number',
    'street',
    'district',
    'city',
    'state',
    'extra_info',
    'phone_number',
    'birth',
    'cpf',
    'balance',
    'image',
    'function_id',
    'father_id',
    'pagseguro_authorization_code',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

    public function function()
    {
        return $this->belongsTo(UserFunction::class, 'function_id', 'function_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id', 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'user_id');
    }

    public function getRouteKeyName()
    {
        return 'user_id';
    }
}
