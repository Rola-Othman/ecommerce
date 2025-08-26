<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proudct extends Model
{
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImageGalleries()
    {
        return $this->hasMany(ProductImageGallery::class, 'product_id', 'id');
    }
}
