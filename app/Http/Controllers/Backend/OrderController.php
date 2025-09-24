<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\canceledOrderDataTable;
use App\DataTables\deliveredOrderDataTable;
use App\DataTables\droppedOffOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\outForDeliveryDataTable;
use App\DataTables\outForDeliveryOrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\DataTables\processedOrderDataTable;
use App\DataTables\shippedOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     ** عرض قائمة الطلبات
     ** display an order list
     ** 
     */
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    /**
     * عرض الطلبات المعلقة
     * display pending orders
     * @param PendingOrderDataTable $dataTable
     */
    public function pendingOrders(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-order');
    }

    /**
     * عرض الطلبات التي تم معالجتها
     * display processed orders
     * @param processedOrderDataTable $dataTable
     */
    public function processedOrders(processedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-order');
    }

    /**
     * عرض الطلبات التي تم تسليمها
     * display delivered orders
     * @param deliveredOrderDataTable $dataTable
     */
    public function droppedOfOrders(droppedOffOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.dropped-off-order');
    }

    /**
     * عرض الطلبات التي تم شحنها
     * display shipped orders
     * @param shippedOrderDataTable $dataTable
     */
    public function shippedOrders(shippedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.shipped-order');
    }

    /**
     * عرض الطلبات التي هي في الطريق للتسليم
     * display out for delivery orders
     * @param outForDeliveryOrderDataTable $dataTable
     */
    public function outForDeliveryOrders(outForDeliveryOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.out-for-delivery-order');
    }

    /**
     * عرض الطلبات التي تم تسليمها
     * display delivered orders
     * @param deliveredOrderDataTable $dataTable
     */
    public function deliveredOrders(deliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered-order');
    }
    /**
     * عرض الطلبات التي تم إلغاؤها
     * display canceled orders
     * @param canceledOrderDataTable $dataTable
     */
    public function canceledOrders(canceledOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.canceled-order');
    }

    /**
     ** عرض تفاصيل الطلب
     ** display order details
     ** @param  int  $id
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.show', compact('order'));
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
     ** حذف الطلب
     ** delete order
     ** @param  string  $id
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // delete order products
        $order->orderProducts()->delete();
        // delete transaction
        $order->transaction()->delete();

        $order->delete();

        return response(['status' => 'success', 'message' => 'Deleted successfully!']);
    }

    /**
     ** تغيير حالة الطلب
     ** change order status
     * @param $request
     * 
     */
    public function changeOrderStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        return response(['status' => 'success', 'message' => 'Updated Order Status']);
    }

    /**
     ** تغيير حالة الدفع
     ** change payment status
     * @param $request
     * 
     */
    public function changePaymentStatus(Request $request)
    {
        $paymentStatus = Order::findOrFail($request->id);
        $paymentStatus->payment_status = $request->status;
        $paymentStatus->save();

        return response(['status' => 'success', 'message' => 'Updated Payment Status Successfully']);
    }
}
