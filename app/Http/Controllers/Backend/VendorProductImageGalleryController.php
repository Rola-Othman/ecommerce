<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductImageGallery;
use App\Models\Proudct;
use App\Traits\FileUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGalleryController extends Controller
{
    use FileUpload;
    /**
     ** عرض قائمة صور معرض المنتج.
     ** Display a image gallery of the product.
     * @param Request $request
     * @param VendorProductImageGalleryDataTable $dataTable
     */
    public function index(Request $request, VendorProductImageGalleryDataTable $dataTable)
    {
        $product = Proudct::findOrFail($request->product);

        /** Check product vendor */
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        return $dataTable->render('vendor.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     ** حفظ صورة جديدة في معرض صور المنتج.
     ** save a new image in the product image gallery.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image.*' => ['required', 'image', 'max:2048']
        ]);

        /** Handle image upload */
        $imagePaths = $this->uploadFiles($request->file('image'));

        foreach ($imagePaths as $path) {
            $productImageGallery = new ProductImageGallery();
            $productImageGallery->image = $path;
            $productImageGallery->product_id = $request->product;
            $productImageGallery->save();
        }

        flash()->success('Uploaded successfully.');

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
     ** حذف صورة من معرض صور المنتج.
     ** Delete an image from the product image gallery.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id):Response
    {
    //    ds('Deleting product image with ID: ' . $id);
        $productImage = ProductImageGallery::findOrFail($id);

        /** Check product vendor */
        if ($productImage->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        $this->deleteFile($productImage->image);
        $productImage->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
