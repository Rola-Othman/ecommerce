<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductsDataTable;
use App\DataTables\SellerProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Proudct;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    function index(SellerProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-product.index');
    }

    function pendingProducts(SellerPendingProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-pending-product.index');
    }

    public function changeApproveStatus(Request $request)
    {
        $product = Proudct::findOrFail($request->id);
        $product->is_approved = $request->value;
        $product->save();

        return response(['message' => 'Product Approve Status Has Been Changed']);
    }
}
