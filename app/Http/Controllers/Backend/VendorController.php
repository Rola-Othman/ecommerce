<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VendorController extends Controller
{
     /**
     * Display the vendor dashboard
     * عرض لوحة التحكم للبائع
     * @return View
     */
    function dashboard() : View
    {
        return view('vendor.dashboard.dashboard');
    }
}
