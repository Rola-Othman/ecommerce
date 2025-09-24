<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeSetting extends Model
{
    protected $fillable = [
        'status', 
        'mode', 
        'country_name', 
        'currency_name', 
        'currency_rate', 
        'client_id', 
        'secret_key'
    ];
}
