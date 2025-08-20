<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductVariantItemController extends Controller
{
    /**
     ** عرض قائمة عناصر متغير المنتج.
     ** Display a listing of the product variant items.
     * @param ProductVariantItemDataTable $dataTable
     */
    public function index(ProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Proudct::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $dataTable->render('admin.product.product-variant-item.index', compact('product', 'variant'));
    }

    /** 
     ** عرض صفحة إنشاء عنصر متغير المنتج.
     ** Display the form for creating a new product variant item.
     * @param int $productId
     * @param int $variantId
     * @return View
     */
    function create($productId, $variantId): View
    {
        $product = Proudct::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return view('admin.product.product-variant-item.create', compact('product', 'variant'));
    }

    /**
     ** تخزين عنصر متغير المنتج الجديد.
     ** Store a newly created product variant item.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'variant_id' => ['integer', 'required'],
            'name' => ['required', 'max:200'],
            'price' => ['integer', 'required'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variantItem = new ProductVariantItem();
        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();
        flash()->success('Created successfully.');

        return redirect()->route(
            'admin.products-variant-item.index',
            ['productId' => $request->product_id, 'variantId' => $request->variant_id]
        );
    }

    /**
     ** عرض صفحة تحرير عنصر متغير المنتج.
     ** Display the form for editing a product variant item.
     * @param string $variantItemId
     * @return View
     */
    public function edit(string $variantItemId): View
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        return view('admin.product.product-variant-item.edit', compact('variantItem'));
    }

    /**
     * * تحديث عنصر متغير المنتج.
     * * Update a product variant item.
     * @param Request $request
     * @param string $variantItemId
     * @return RedirectResponse
     */
    public function update(Request $request, string $variantItemId): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'price' => ['integer', 'required'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        flash()->success('Update successfully.');

        return redirect()->route(
            'admin.products-variant-item.index',
            ['productId' => $variantItem->productVariant->product_id, 'variantId' => $variantItem->product_variant_id]
        );
    }

    /**
     * * حذف عنصر متغير المنتج.
     * * Delete a product variant item.
     * @param string $variantItemId
     * @return Response
     */
    public function destroy(string $variantItemId): Response
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        $variantItem->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    /**
     * * تغيير حالة عنصر متغير المنتج.
     * * Change the status of a product variant item.
     * @param Request $request
     * @return Response
     */
    public function chageStatus(Request $request)
    {
        $variantItem = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->status == 'true' ? 1 : 0;
        $variantItem->save();

        return response(['message' => 'Status has been updated!']);
    }
}
