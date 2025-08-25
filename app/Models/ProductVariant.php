<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    
    public function product()
    {
        return $this->belongsTo(Proudct::class);
    }
    
    public function productVariantItems()
    {
        return $this->hasMany(ProductVariantItem::class);
    }
}
