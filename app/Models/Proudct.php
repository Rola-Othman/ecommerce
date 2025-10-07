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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
