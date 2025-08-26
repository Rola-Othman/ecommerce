<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Contracts\View\View;


class FlashSaleController extends Controller
{
    /**
     ** عرض جميع منتجات الفلاش سل
     ** Display all falsh sell page
     * @return View
     */
    function index(): View
    {
        $flashSaleDate = FlashSale::first();
        $flashSaleItems = FlashSaleItem::where('status', 1)->orderBy('id', 'ASC')->pluck('product_id')->toArray();

        return view('frontend.pages.flash-sale', compact('flashSaleDate', 'flashSaleItems'));
    }
}
