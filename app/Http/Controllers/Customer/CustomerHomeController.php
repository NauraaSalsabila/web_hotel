<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class CustomerHomeController extends Controller
{
    public function index()
    {
        // Get the total count of completed and pending orders
        $total_completed_orders = Order::where('status', 'Completed')
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->count();

        $total_pending_orders = Order::where('status', 'Pending')
            ->where('customer_id', Auth::guard('customer')->user()->id)
            ->count();

        // Redirect to the customer order view regardless of whether there are orders
        return redirect()->route('customer_order_view');
    }
}




