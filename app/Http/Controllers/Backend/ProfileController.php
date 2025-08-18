<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUpload;

    /**
     * Display the admin profile page.
     * عرض صفحة الملف الشخصي للمسؤول
     * @return View
     */
    function index(): View
    {
        return view('admin.profile.index');
    }

    /**
     * Update the admin profile.
     * تحديث ملف المسؤول الشخصي
     * @param Request $request
     * @return RedirectResponse
     */
    function updateProfile(Request $request): RedirectResponse
    {
        $admin = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'image' => ['image', 'max:3000']
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image')); // تعديل الصورة | Update image
            $this->deleteFile($admin->image); // حذف الصورة القديمة | delete old image
            $admin->image = $imagePath;
        }

        // $imagePath = $this->uploadFile($request->file('image'));

        $admin->name = $request->name;
        $admin->email = $request->email;
        //$admin->image = $imagePath;
        $admin->save();
        flash()->success('Profile Updated successfully.');
        return redirect()->back();
    }

    /**
     * Update the admin password.
     * تحديث كلمة مرور المسؤول
     * @param Request $request
     * @return RedirectResponse
     */
    function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ]);
        // $admin = Auth::user();
        // $admin->password = bcrypt($request->password);
        // $admin->save();
        $request->user()->update([
            'password' => bcrypt($request->password),
        ]); 
         flash()->success('Password Updated successfully.');
        return redirect()->back();
    }
}
