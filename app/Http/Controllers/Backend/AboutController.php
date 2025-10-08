<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     ** عرض صفحة من نحن في لوحة التحكم
     ** Display the about page in the admin panel
     * @return View
     */
    public function index()
    {
        $content = About::first();
        return view('admin.about.index', compact('content'));
    }

    /**
     ** تحديث صفحة من نحن في لوحة التحكم
     ** Update the about page in the admin panel
     * @param Request $request
     * @return Redirect
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required']
        ]);

        About::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content
            ]
        );
        flash()->success('Updated successfully.');

        return redirect()->back();
    }
}
