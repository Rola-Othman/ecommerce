<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVendorProfileController extends Controller
{
    use FileUpload;
    /**
     * عرض قائمة ملفات تعريف البائعين
     * Display a listing of vendor profiles.
     * @return View
     */
    public function index(): View
    {
        $profile = Vendor::where('user_id', Auth::user()->id)->first();
        return view('admin.vendor-profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * التعديل على ملف تعريف البائع
     * Update the vendor profile.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request):RedirectResponse
    {
        $request->validate([
            'banner' => ['nullable', 'image', 'max:3000'],
           // 'shop_name' => ['required', 'max:200'],
            'phone' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:200'],
            'address' => ['required'],
            'description' => ['required'],
            'fb_link' => ['nullable', 'url'],
            'tw_link' => ['nullable', 'url'],
            'insta_link' => ['nullable', 'url'],
        ]);

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();

        if ($request->hasFile('banner')) {
            $bannerPath = $this->uploadFile($request->file('banner'));
            $this->deleteFile($vendor->image); 
            $vendor->banner = $bannerPath;
        }

        $vendor->phone = $request->phone;
       // $vendor->shop_name = $request->shop_name;
        $vendor->email = $request->email;
        $vendor->address = $request->address;
        $vendor->description = $request->description;
        $vendor->fb_link = $request->fb_link;
        $vendor->tw_link = $request->tw_link;
        $vendor->insta_link = $request->insta_link;
        $vendor->save();

        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
