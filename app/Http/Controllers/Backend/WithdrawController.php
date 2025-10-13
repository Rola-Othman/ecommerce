<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WithdrawRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    /**
     * * عرض طلبات السحب
     * * Display a vendor withdraw requests
     * @param WithdrawRequestDataTable $dataTable
     */
    function index(WithdrawRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.withdraw.index');
    }

    /**
     * * عرض تفاصيل طلب السحب
     * * Show the details of a withdraw request
     * @param string $id
     * @return View
     */
    function show(string $id)
    {
        $request = WithdrawRequest::findOrFail($id);
        return view('admin.withdraw.show', compact('request'));
    }

    /**
     * * تحديث حالة طلب السحب
     * * Update the status of a withdraw request
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,paid,declined']
        ]);

        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->status = $request->status;
        $withdraw->save();

flash()->success('Updated successfully.');
        return redirect()->route('admin.withdraw.index');
    }
}
