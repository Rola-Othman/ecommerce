<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SliderController extends Controller
{
    use FileUpload;
    /**
     * عرض قائمة الشرائح.| Display the list of sliders.
     * @return View
     */
    public function index(SliderDataTable $dataTable)
    {
        //  dd($dataTable);
        return $dataTable->render('admin.slider.index');
    }

    /**
     * عرض نموذج إنشاء شريحة جديدة.| Show the form for creating a new slider.
     * @return View
     */
    public function create(): View
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'max:2000'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'strating_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required']
        ]);

        $slider = new Slider();
        if ($request->hasFile('banner')) {
            $bannerPath = $this->uploadFile($request->file('banner')); // تعديل الصورة | Update image
            $this->deleteFile($slider->banner); // حذف الصورة القديمة | delete old image
            $slider->banner = $bannerPath;
        }

        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status ? 1 : 0;
        $slider->save();
        Cache::forget('sliders');
        flash()->success('Created successfully.');
        return redirect()->route('admin.slider.index');
    }


    /**
     * عرض نموذج تحرير شريحة معينة.| Show the form for editing a specific slider.
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * تحديث شريحة معينة.| Update a specific slider.
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'banner' => ['nullable', 'image', 'max:2000'],
            'type' => ['string', 'max:200'],
            'title' => ['required', 'max:200'],
            'strating_price' => ['max:200'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required']
        ]);

        $slider = Slider::findOrFail($id);
        if ($request->hasFile('banner')) {
            $bannerPath = $this->uploadFile($request->file('banner')); // تعديل الصورة | Update image
            $this->deleteFile($slider->banner); // حذف الصورة القديمة | delete old image
            $slider->banner = $bannerPath;
        }

        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();
        Cache::forget('sliders');
        flash()->success('Updated successfully.');
        return redirect()->route('admin.slider.index');
    }

    /**
     * حذف شريحة معينة.| Delete a specific slider.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id): Response
    {
        $slider = Slider::findOrFail($id);
        $this->deleteFile($slider->banner);
        $slider->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
