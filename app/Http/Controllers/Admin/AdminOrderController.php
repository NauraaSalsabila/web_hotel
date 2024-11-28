<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::get();
        return view('admin.orders', compact('orders'));
    }

    public function invoice($id)
    {
        $order = Order::where('id',$id)->first();
        $order_detail = OrderDetail::where('order_id',$id)->get();
        $customer_data = Customer::where('id',$order->customer_id)->first();
        return view('admin.invoice', compact('order','order_detail','customer_data'));
    }

    public function delete($id)
    {
        $obj = Order::where('id',$id)->delete();
        $obj = OrderDetail::where('order_id',$id)->delete();

        return redirect()->back()->with('success', 'Order is deleted successfully');
    }

    public function change_payment_status($id)
{
    $order = Order::findOrFail($id);

    // Ubah status pembayaran
    $order->payment_status = !$order->payment_status; // Toggle status
    $order->save();

    return redirect()->back()->with('success', 'Payment status updated successfully.');
}

}
