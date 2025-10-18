<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PusherSetting extends Model
{
    protected $fillable = [
        'id',
        'pusher_app_id',
        'pusher_key',
        'pusher_secret',
        'pusher_cluster'
    ];
}
