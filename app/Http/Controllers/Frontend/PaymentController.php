<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Show payment page
     * عرض صفحة الدفع
     */
    public function index()
    {
        if (!Session::has('address')) {
            return redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    /**
     * Show payment success page
     * عرض صفحة نجاح الدفع
     */
    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }
}
