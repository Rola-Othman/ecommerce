<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FooterInfo;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FooterInfoController extends Controller
{
    use FileUpload;
    /**
     ** Display a footer info page
     ** عرض صفحة معلومات التذييل
     * @return View
     */
    public function index()
    {
        $footerInfo = FooterInfo::first();
        return view('admin.footer.footer-info.index', compact('footerInfo'));
    }


    /**
     ** update or add a footer info
     ** تحديث او اضافة معلومات التذييل
     * @param Request $request
     * @param string $id
     */
    public function update(Request $request, string $id)
    {
        $id = 1;
        $request->validate([
            'logo' => ['nullable', 'image', 'max:3000'],
            'phone' => ['max:100'],
            'email' => ['max:100'],
            'address' => ['max:300'],
            'copyright' => ['max:200']
        ]);

        $footerInfo = FooterInfo::find($id);
        /** Handle file upload */
        $imagePath = ''; //$this->uploadFile($request->file('logo'));
       // dd($request->all());
        if ($request->hasFile('logo')) {
            $imagePath = $this->uploadFile($request->file('logo'));
            $this->deleteFile($footerInfo->logo);
        }
        FooterInfo::updateOrCreate(
            ['id' => 1],
            [
                'logo' => empty(!$imagePath) ? $imagePath : $footerInfo->logo, //empty(!$imagePath) ? $imagePath : $footerInfo->banner,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'copyright' => $request->copyright

            ]
        );
        Cache::forget('footer_info');
        flash()->success('Updated successfully.');
        return redirect()->back();
    }
}
