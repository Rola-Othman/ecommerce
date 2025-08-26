<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     * عرض صفحة الرئيسية
     * @return View
     */
    function index(): View
    {
        $sliders = Slider::where('status', 1)
            ->orderBy('serial', 'asc')
            ->get();
        $flashSaleDate = FlashSale::first();
        $flashSaleItems = FlashSaleItem::where('show_at_home', 1)->where('status', 1)->pluck('product_id')->toArray();
      
        return view('frontend.home.home', compact('sliders', 'flashSaleDate', 'flashSaleItems'));
    }
}
