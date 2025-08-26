<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductsDataTable;
use App\DataTables\SellerProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Proudct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SellerProductController extends Controller
{
    /**
     ** عرض قائمة المنتجات للبائعين وحالة المنتج
     ** Display the product list for vendors and status of product
     * @param SellerProductsDataTable $dataTable
     */
    function index(SellerProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-product.index');
    }

    /**
     ** عرض قائمة المنتجات المعلقة للبائعين 
     ** Display thepending product list for vendors 
     * @param SellerPendingProductsDataTable $dataTable
     */
    function pendingProducts(SellerPendingProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-pending-product.index');
    }

    
    /**
     ** الموافقة ع المنتج للبائع
     ** Approve on the vendor product
     * @param Request $request
     * @return Response
     */
    public function changeApproveStatus(Request $request):Response
    {
        $product = Proudct::findOrFail($request->id);
        $product->is_approved = $request->value;
        $product->save();

        return response(['message' => 'Product Approve Status Has Been Changed']);
    }
}
