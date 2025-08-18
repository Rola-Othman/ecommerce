<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard | عرض لوحة تحكم المستخدم
     * @return \Illuminate\Contracts\View\View
     */
    function index() : View {
        return view('frontend.dashboard.dashboard');
    }
}
