<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Room;
use App\Models\Subscriber;

class AdminHomeController extends Controller
{
    public function index()
    {
        
        $total_active_customers = Customer::where('status',1)->count();
        $total_pending_customers = Customer::where('status',0)->count();
        $total_rooms = Room::count();


        return view('admin.home', compact('total_active_customers','total_pending_customers','total_rooms'));
    }
}
