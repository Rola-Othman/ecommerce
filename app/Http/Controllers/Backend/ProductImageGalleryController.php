<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductImageGallery;
use App\Models\Proudct;
use App\Traits\FileUpload;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use FileUpload;
    /**
     ** عرض صفحة معرض صور المنتج
     ** display the product image gallery page
     * @param ProductImageGalleryDataTable $dataTable
     * 
     */
    public function index(Request $request, ProductImageGalleryDataTable $dataTable)
    {
        $product = Proudct::findOrFail($request->product);
        return $dataTable->render('admin.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image.*' => ['required', 'image', 'max:2048']
        ]);

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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $productImage = ProductImageGallery::findOrFail($id);
        $this->deleteFile($productImage->image);
        $productImage->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
