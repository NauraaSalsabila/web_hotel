<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id',Auth::guard('customer')->user()->id)->get();
        return view('customer.orders', compact('orders'));
    }

    public function invoice($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->first();
    
        // Periksa apakah pesanan ditemukan
        if (!$order) {
            return redirect()->route('customer.orders')->with('error', 'Order not found.');
        }
    
        // Periksa status pembayaran
        if ($order->payment_status == 0) {
            return redirect()->route('customer.orders')->with('error', 'Payment has not been verified yet. Please wait for admin approval.');
        }
    
        $order_detail = OrderDetail::where('order_id', $id)->get();
        return view('customer.invoice', compact('order', 'order_detail'));
    }

    public function uploadPaymentProof(Request $request, $orderId)
{
    $order = Order::findOrFail($orderId);

    // Hanya proses upload bukti pembayaran jika metode pembayaran bukan Cash
    if ($order->payment_method == 'Cash') {
        return redirect()->route('customer.orders')->with('info', 'No proof required for Cash payments.');
    }

    // Validate the file for non-Cash payments
    $request->validate([
        'payment_proof' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Store the file in the 'public/payment_proofs' directory
    if ($request->hasFile('payment_proof')) {
        $file = $request->file('payment_proof');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Store the file
        $path = $file->storeAs('public/payment_proofs', $filename);

        // Save the file path in the database
        $order->payment_proof = $filename;
        $order->save();
    }

    return redirect()->route('customer.orders')->with('success', 'Payment proof uploaded successfully!');
}


    
}
