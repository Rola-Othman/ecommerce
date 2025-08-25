<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantController extends Controller
{
    /**
     ** عرض قائمة متغيرات المنتج
     ** show the list of product variants
     * @param Request $request
     * @param VendorProductVariantDataTable $dataTable
     */
    public function index(Request $request, VendorProductVariantDataTable $dataTable)
    {
        $product = Proudct::findOrFail($request->product);

        /** Check product vendor */
        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        return $dataTable->render('vendor.product.product-variant.index', compact('product'));
    }

    /**
     ** عرض نموذج إنشاء متغير منتج جديد
     ** Show the form for creating a new product variant
     * @return View
     */
    public function create(): View
    {
        return view('vendor.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => ['integer', 'required'],
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        $varinat = new ProductVariant();
        $varinat->product_id = $request->product;
        $varinat->name = $request->name;
        $varinat->status = $request->status;
        $varinat->save();

        flash()->success('Created successfully.');

        return redirect()->route('vendor.products-variant.index', ['product' => $request->product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        /** Check product vendor */
        if ($variant->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }
        return view('vendor.product.product-variant.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        $varinat = ProductVariant::findOrFail($id);
        /** Check product vendor */
        if($varinat->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }
        $varinat->name = $request->name;
        $varinat->status = $request->status;
        $varinat->save();

        flash()->success('Updated successfully.');

        return redirect()->route('vendor.products-variant.index', ['product' => $varinat->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $varinat = ProductVariant::findOrFail($id);
        
        /** Check product vendor */
        if($varinat->product->vendor_id !== Auth::user()->vendor->id){
            abort(404);
        }

        $variantItemCheck = ProductVariantItem::where('product_variant_id', $varinat->id)->count();
        if($variantItemCheck > 0){
            return response(['status' => 'error', 'message' => 'This variant contain variant items in it delete the variant items first for delete this variant!']);
        }
        $varinat->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    /**
     ** Change the status of the product variant.
     ** تغيير حالة متغير المنتج
     * @param Request $request   
     * @return Response
     */
    public function changeStatus(Request $request): Response
    {
        $varinat = ProductVariant::findOrFail($request->id);
        $varinat->status = $request->status == 'true' ? 1 : 0;
        $varinat->save();

        return response(['message' => 'Status has been updated!']);
    }
}
