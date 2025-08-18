<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard
     * عرض لوحة التحكم للادمين
     * @return View
     */
    function dashboard() : View
    {
        return view('admin.dashboard');
    }

    function login() : View {
        return view('admin.auth.login');
    }
}
