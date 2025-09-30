<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $primaryKey = 'email_id';
    public $timestamps = false;

    protected $fillable = [
        'subject',
        'content',
        'date',
        'receiver_id',
        'sender_id',
        'sender_function_id',
    ];
}