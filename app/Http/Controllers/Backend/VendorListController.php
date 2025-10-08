<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorListDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendorListController extends Controller
{
    /**
     * عرض قائمة البائعين
     * Display a list of vendors
     * @param VendorListDataTable $dataTable
     */
    public function index(VendorListDataTable $dataTable)
    {
        return $dataTable->render('admin.vendor-list.index');
    }

    /**
     * تغيير حالة البائع (نشط/غير نشط)
     * Change the status of a vendor (active/inactive)
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request)
    {
        $customer = User::findOrFail($request->id);
        $customer->status = $request->status == 'true' ? 'active' : 'inactive';
        $customer->save();

        return response(['message' => 'Status has been updated!']);
    }
}
