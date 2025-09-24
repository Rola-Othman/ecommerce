<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProudct extends Model
{
        protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'product_name',
        'variants',
        'variant_total',
        'unit_price',
        'qty',
    ];

     public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function product()
    {
        return $this->belongsTo(Proudct::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
