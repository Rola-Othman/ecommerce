<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     ** عرض صفحة الاعدادت
     ** Display settings page
     * @return View
     */
    function index(): View
    {
        $generalSettings = GeneralSetting::first();
        return view('admin.setting.index', compact('generalSettings'));
    }

    /**
     ** تحديث الاعدادت العامة
     ** Save change general settings
     */
    public function generalSettingUpdate(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'max:200'],
            'layout' => ['required', 'max:200'],
            'contact_email' => ['required', 'max:200'],
            'currency_name' => ['required', 'max:200'],
            'time_zone' => ['required', 'max:200'],
            'currency_icon' => ['required', 'max:200'],
        ]);

        GeneralSetting::updateOrCreate(
            ['id' => 1],
            [
                'site_name' => $request->site_name,
                'layout' => $request->layout,
                'contact_email' => $request->contact_email,
                // 'contact_phone' => $request->contact_phone,
                // 'contact_address' => $request->contact_address,
                // 'map' => $request->map,
                'currency_name' => $request->currency_name,
                'currency_icon' => $request->currency_icon,
                'time_zone' => $request->time_zone
            ]
        );

        flash()->success('Updated successfully.');

        return redirect()->back();
    }
}
