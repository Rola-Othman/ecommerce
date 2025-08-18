<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductImageGallery;
use App\Models\Proudct;
use App\Traits\FileUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     ** حفظ صور المنتج في معرض الصور
     ** Save product images to the image gallery
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request):RedirectResponse
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
     ** حذف صورة من معرض صور المنتج
     ** Delete an image from the product image gallery
     * @param string $id
     * @return Response
     */
    public function destroy(string $id):Response
    {
        
        $productImage = ProductImageGallery::findOrFail($id);
        $this->deleteFile($productImage->image);
        $productImage->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
