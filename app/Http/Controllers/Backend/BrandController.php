<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use FileUpload;
    /**
     * عرض صفحة العلامات التجارية
     * Show brands page
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * عرض صفحة إنشاء علامة تجارية جديدة
     * Display the adding brand page
     * @return View
     */
    public function create(): View
    {
        return view('admin.brand.create');
    }

    /**
     * حفظ العلامة التجارية الجديدة
     * Store a newly created brand
     * @param Request $requestRedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => ['image', 'required', 'max:2000'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required']
        ]);

        $logoPath = $this->uploadFile($request->file('logo'));

        $brand = new Brand();

        $brand->logo = $logoPath;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        flash()->success('Created successfully.');

        return redirect()->route('admin.brand.index');
    }

    /**
     * عرض صفحة تعديل العلامة التجارية
     * Display the edit brand page
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => ['image', 'max:2000'],
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
            'status' => ['required']
        ]);

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadFile($request->file('logo'));
            $this->deleteFile($brand->logo);
            $brand->logo = $logoPath;
        }

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        flash()->success('Updated successfully.');

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        // if (Product::where('brand_id', $brand->id)->count() > 0) {
        //     return response(['status' => 'error', 'message' => 'This brand have products you can\'t delete it.']);
        // }
        $this->deleteFile($brand->logo);
        $brand->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
    /**
     * Change the status of the brand.
     * تغيير حالة العلامة التجارية
     * @param Request $request
     */
    public function changeStatus(Request $request)
    {
        $category = Brand::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status has been updated!']);
    }
}
