<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use App\Models\Proudct;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductVariantController extends Controller
{
    /**
     * * عرض قائمة المتغيرات للمنتج المحدد.
     * *show the list of variants for the specified product.
     * @param Request $request
     * @param ProductVariantDataTable $dataTable
     */
    public function index(Request $request, ProductVariantDataTable $dataTable)
    {
        $product = Proudct::findOrFail($request->product);
        return $dataTable->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     ** عرض نموذج لإنشاء متغير جديد.
     * * Show the form for creating a new variant.
     * @return View
     */
    public function create(Request $request): View
    {
        return view('admin.product.product-variant.create');
    }

    /**
     * * حفظ متغير جديد في قاعدة البيانات.
     * * Store a newly created variant in the database.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
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

        return redirect()->route('admin.products-variant.index', ['product' => $request->product]);
    }

    /**
     ** عرض نموذج لتحرير متغير موجود.
     * * Show the form for editing an existing variant.
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.product-variant.edit', compact('variant'));
    }

    /**
     ** تحديث متغير موجود في قاعدة البيانات.
     * * Update an existing variant in the database.
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        $varinat = ProductVariant::findOrFail($id);
        $varinat->name = $request->name;
        $varinat->status = $request->status;
        $varinat->save();

        flash()->success('Updated successfully.');

        return redirect()->route('admin.products-variant.index', ['product' => $varinat->product_id]);
    }

    /**
     * *حذف متغير من قاعدة البيانات.
     * * Delete a variant from the database.
     * @param string $id
     * @return Response
     */
    public function destroy(string $id): Response
    {
        $varinat = ProductVariant::findOrFail($id);
        $variantItemCheck = ProductVariantItem::where('product_variant_id', $varinat->id)->count();
        if($variantItemCheck > 0){
            return response(['status' => 'error', 'message' => 'This variant contain variant items in it delete the variant items first for delete this variant!']);
        }
        $varinat->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $varinat = ProductVariant::findOrFail($request->id);
        $varinat->status = $request->status == 'true' ? 1 : 0;
        $varinat->save();

        return response(['message' => 'Status has been updated!']);
    }
}
