<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaypalSetting;
use App\Models\StripeSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    /**
     ** display payment settings page
     ** عرض صفحة إعدادات الدفع
     * @return View
     */
    public function index():View
    {
         $paypalSetting = PaypalSetting::first();
         $stripeSetting = StripeSetting::first();
        // $razorpaySetting = RazorpaySetting::first();
        // $codSetting = CodSetting::first();
        //, compact('paypalSetting', 'stripeSetting', 'razorpaySetting', 'codSetting')

        return view('admin.payment-settings.index', compact('paypalSetting', 'stripeSetting'));
    }
}
