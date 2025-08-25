<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProudctDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\Proudct;
use App\Models\SubCategory;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorProductController extends Controller
{
    use FileUpload;
    /**
     ** عرض المنتجات الخاصة بالبائعين
     ** Display the products of vendors
     * @param VendorProudctDataTable $dataTable
     */
    public function index(VendorProudctDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     ** حفظ المنتج الخاص بالبائع
     ** Store the vendor product
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max: 600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required']
        ]);

        $imagePath = $this->uploadFile($request->file('image'));

        $product = new Proudct();
        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = 0;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();
        flash()->success('Created successfully.');

        return redirect()->route('vendor.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     ** عرض صفحة تعديل المنتج
     ** Show the edit product page
     ** @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $product = Proudct::findOrFail($id);

        /** Check if it's the owner of the product */
        if ($product->vendor_id != Auth::user()->vendor->id) {
            abort(404);
        }

        $subCategories = SubCategory::where('category_id', $product->category_id)->get();
        $childCategories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();
        $categories = Category::all();
        $brands = Brand::all();

        return view(
            'vendor.product.edit',
            compact(
                'product',
                'subCategories',
                'childCategories',
                'categories',
                'brands'
            )
        );
    }

    /**
     ** حفظ التعديلات على المنتج
     ** Save the product modifications
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        ds($request->all());
        $request->validate([
            'image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'qty' => ['required'],
            'short_description' => ['required', 'max: 600'],
            'long_description' => ['required'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required']
        ]);

        $product = Proudct::findOrFail($id);

        if ($product->vendor_id != Auth::user()->vendor->id) {
            abort(404);
        }

        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image')); // تعديل الصورة | Update image
            $this->deleteFile($product->image); // حذف الصورة القديمة | delete old image
            $product->thumb_image = $imagePath;
        }

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->qty = $request->qty;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = $product->is_approved;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        flash()->success('Updated successfully.');

        return redirect()->route('vendor.products.index');
    }

    /**
     ** حذف المنتج
     ** Delete the product
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id):Response
    {
         $product = Proudct::findOrFail($id);
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }

        /** Delte the main product image */
        $this->deleteFile($product->thumb_image);

        /** Delete product gallery images */
        $galleryImages = ProductImageGallery::where('product_id', $product->id)->get();
        foreach($galleryImages as $image){
            $this->deleteFile($image->image);
            $image->delete();
        }

        /** Delete product variants if exist */
        $variants = ProductVariant::where('product_id', $product->id)->get();

        foreach($variants as $variant){
            $variant->productVariantItems()->delete();
            $variant->delete();
        }

        $product->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $product = Proudct::findOrFail($request->id);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response(['message' => 'Status has been updated!']);
    }

    /**
     * Get all product sub categores
     */

    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->id)->get();

        return $subCategories;
    }

    public function getChildCategories(Request $request)
    {
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->get();

        return $childCategories;
    }
}
