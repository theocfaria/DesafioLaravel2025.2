<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'functions';
    public $timestamps = false;
    protected $primaryKey = 'function_id';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'function_id');
    }
}