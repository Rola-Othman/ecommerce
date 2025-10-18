<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherSetting;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use FileUpload;
    /**
     ** عرض صفحة الاعدادت
     ** Display settings page
     * @return View
     */
    function index(): View
    {
        $generalSettings = GeneralSetting::first();
        $emailSettings = EmailConfiguration::first();
        $logoSetting = LogoSetting::first();
        $pusherSetting = PusherSetting::first();
        return view('admin.setting.index', compact('generalSettings', 'emailSettings', 'logoSetting', 'pusherSetting'));
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
                'contact_phone' => $request->contact_phone,
                'contact_address' => $request->contact_address,
                'map' => $request->map,
                'currency_name' => $request->currency_name,
                'currency_icon' => $request->currency_icon,
                'time_zone' => $request->time_zone
            ]
        );

        flash()->success('Updated successfully.');

        return redirect()->back();
    }

    /**
     ** تحديث اعدادات البريد الالكتروني
     ** Update email configuration settings
     * @param Request $request
     */
    public function emailConfigSettingUpdate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'host' => ['required', 'max:200'],
            'username' => ['required', 'max:200'],
            'password' => ['required', 'max:200'],
            'port' => ['required', 'max:200'],
            'encryption' => ['required', 'max:200'],
        ]);

        EmailConfiguration::updateOrCreate(
            ['id' => 1],
            [
                'email' => $request->email,
                'host' => $request->host,
                'username' => $request->username,
                'password' => $request->password,
                'port' => $request->port,
                'encryption' => $request->encryption,
            ]
        );

        flash()->success('Updated successfully.');
        return redirect()->back();
    }

    public function logoSettingUpdate(Request $request)
    {
        $request->validate([
            'logo' => ['image', 'max:3000'],
            'favicon' => ['image', 'max:3000'],
        ]);
        $logoPath = '';
        $favicon = '';

        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadFile($request->file('logo'));
            $this->deleteFile($request->old_logo);
        }

        if ($request->hasFile('favicon')) {
            $favicon = $this->uploadFile($request->file('favicon'));
            $this->deleteFile($request->old_favicon);
        }

        $logoPath = $this->uploadFile($request->file('logo'));
        $favicon = $this->uploadFile($request->file('favicon'));

        LogoSetting::updateOrCreate(
            ['id' => 1],
            [
                'logo' => (!empty($logoPath)) ? $logoPath : $request->old_logo,
                'favicon' => (!empty($favicon)) ? $favicon : $request->old_favicon
            ]
        );

        flash()->success('Updated successfully.');

        return redirect()->back();
    }

    /**
     ** تحديث اعدادات بوشير
     ** Update Pusher settings
     * @param Request $request
     * @return RedirectResponse
     */
    function pusherSettingUpdate(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'pusher_app_id' => ['required'],
            'pusher_key' => ['required'],
            'pusher_secret' => ['required'],
            'pusher_cluster' => ['required'],
        ]);

        PusherSetting::updateOrCreate(
            ['id' => 1],
            $validatedData
        );
        flash()->success('Updated successfully.');
        return redirect()->back();
    }
}
