<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileControllrt extends Controller
{
    use FileUpload;
    /**
     * Display the user profile page.
     * عرض صفحة الملف الشخصي للمستخدم.
     * @return View
     */
    function index(): View
    {
        return view('frontend.dashboard.profile');
    }

    /**
     * Update the user profile.
     * تحديث ملف المستخدم الشخصي.
     * @param Request $request
     * @return RedirectResponse
     */
    function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'image' => ['image', 'max:3000']
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image')); // تعديل الصورة | Update image
            $this->deleteFile($user->image); // حذف الصورة القديمة | delete old image
            $user->image = $imagePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        flash()->success('Profile Updated successfully.');
        return redirect()->back();
    }

    
    /**
     * Update the user password.
     * تحديث كلمة مرور المستخدم
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
