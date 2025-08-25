<?php

namespace App\Http\Controllers;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorProductVariantItemController extends Controller
{
    /**
     ** عرض قائمة عناصر متغير المنتج
     ** Show the list of product variant items
     * @param VendorProductVariantItemDataTable $dataTable
     * @param $productId
     * @param $variantId
     */
    public function index(VendorProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Proudct::findOrFail($productId);
        $variant = ProductVariant::findOrFail($variantId);
        return $dataTable->render('vendor.product.product-variant-item.index', compact('product', 'variant'));
    }

    /**
     ** عرض نموذج إنشاء عنصر متغير منتج جديد
     ** Show the form for creating a new product variant item
     * @param string $productId
     * @param string $variantId
     * @return View
     */
    public function create(string $productId, string $variantId): View
    {
        $variant = ProductVariant::findOrFail($variantId);
        $product = Proudct::findOrFail($productId);
        return view('vendor.product.product-variant-item.create', compact('variant', 'product'));
    }

    /**
     ** حفظ عنصر متغير منتج جديد
     ** Store a newly created product variant item
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
            'vendor.products-variant-item.index',
            ['productId' => $request->product_id, 'variantId' => $request->variant_id]
        );
    }

    /**
     ** عرض نموذج تحرير عنصر متغير منتج
     ** Show the form for editing a product variant item
     * @param string $variantItemId
     * @return View
     */
    public function edit(string $variantItemId): View
    {
        $variantItem = ProductVariantItem::findOrFail($variantItemId);
        return view('vendor.product.product-variant-item.edit', compact('variantItem'));
    }

    public function update(Request $request, string $variantItemId)
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
            'vendor.products-variant-item.index',
            ['productId' => $variantItem->productVariant->product_id, 'variantId' => $variantItem->product_variant_id]
        );
    }

    /**
     **حذف عنصر متغير منتج
     ** Remove the specified product variant item
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
     ** تغيير حالة عنصر متغير منتج
     ** Change the status of a product variant item
     * @param Request $request
     * @return Response
     */
    public function chageStatus(Request $request): Response
    {
        $variantItem = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->status == 'true' ? 1 : 0;
        $variantItem->save();

        return response(['message' => 'Status has been updated!']);
    }
}
