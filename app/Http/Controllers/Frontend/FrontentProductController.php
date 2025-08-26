<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Proudct;
use Illuminate\Http\Request;

class FrontentProductController extends Controller
{
    public function showProduct(string $slug)
    {
        $product = Proudct::with(['vendor', 'variants', 'category', 'productImageGalleries'])->where('slug', $slug)->where('status', 1)->first();
  
        return view('frontend.pages.product-detail', compact('product'));
    }
}
