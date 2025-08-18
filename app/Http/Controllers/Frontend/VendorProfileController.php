<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProfileController extends Controller
{
    use FileUpload;
    /**
     * Display the vendor profile page.
     * عرض صفحة الملف الشخصي للبائع.
     * @return View
     */
    function index(): View
    {
        return view('vendor.dashboard.profile');
    }

    /**
     * Update the vendor profile.
     * تحديث ملف البائع الشخصي.
     * @param Request $request
     * @return RedirectResponse
     */
    function updateProfile(Request $request): RedirectResponse
    {
        $vendor = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $vendor->id],
            'image' => ['image', 'max:3000']
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image')); // تعديل الصورة | Update image
            $this->deleteFile($vendor->image); // حذف الصورة القديمة | delete old image
            $vendor->image = $imagePath;
        }

        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->save();
        flash()->success('Profile Updated successfully.');
        return redirect()->back();
    }

    
    /**
     * Update the vendor password.
     * تحديث كلمة مرور البائع
     * @param Request $request
     * @return RedirectResponse
     */
    function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]); 
         flash()->success('Password Updated successfully.');
        return redirect()->back();
    }

}
