<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
  function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
