<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleItem extends Model
{
     public function product()
    {
        return $this->belongsTo(Proudct::class);
    }
}
