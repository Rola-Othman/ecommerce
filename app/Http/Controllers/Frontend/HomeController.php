<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
    function index() : View {
        $sliders = Slider::where('status', 1)
            ->orderBy('serial', 'asc')
            ->get();
          return view('frontend.home.home', compact('sliders'));
    }
}
