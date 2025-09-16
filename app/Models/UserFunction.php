<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFunction extends Model
{
    use HasFactory;

    protected $table = 'functions';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'function_id');
    }
}
