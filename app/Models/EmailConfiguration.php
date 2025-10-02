<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfiguration extends Model
{
    protected $fillable = [
        'email',
        'host',
        'username',
        'password',
        'port',
        'encryption'
    ];
}
