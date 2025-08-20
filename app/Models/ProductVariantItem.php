<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantItem extends Model
{
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
