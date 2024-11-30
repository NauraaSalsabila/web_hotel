<?php

namespace App\Http\Controllers\Front;

use Stripe\Charge;
use Stripe;
use App\Models\Room;
use App\Models\Order;
use App\Models\Customer;
use App\Mail\Websitemail;
use App\Models\BookedRoom;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    
    public function cart_submit(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'checkin_checkout' => 'required',
            'adult' => 'required'
        ]);

        $dates = explode(' - ',$request->checkin_checkout);
        $checkin_date = $dates[0];
        $checkout_date = $dates[1];

        $d1 = explode('/',$checkin_date);
        $d2 = explode('/',$checkout_date);
        $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
        $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
        $t1 = strtotime($d1_new);
        $t2 = strtotime($d2_new);

        $cnt = 1;
        while(1) {
            if($t1>=$t2) {
                break;
            }
            $single_date = date('d/m/Y',$t1);
            $total_already_booked_rooms = BookedRoom::where('booking_date',$single_date)->where('room_id',$request->room_id)->count();

            $arr = Room::where('id',$request->room_id)->first();
            $total_allowed_rooms = $arr->total_rooms;

            if($total_already_booked_rooms == $total_allowed_rooms) {
                $cnt = 0;
                break;
            }
            $t1 = strtotime('+1 day',$t1);
        }

        if($cnt == 0) {
            return redirect()->back()->with('error', 'Maximum number of this room is already booked');
        }        
        
        session()->push('cart_room_id',$request->room_id);
        session()->push('cart_checkin_date',$checkin_date);
        session()->push('cart_checkout_date',$checkout_date);
        session()->push('cart_adult',$request->adult);
        session()->push('cart_children',$request->children);

        return redirect()->back()->with('success', 'Room is added to the cart successfully.');
    }

    public function cart_view()
    {
        return view('front.cart');
    }

    public function cart_delete($id)
    {
        $arr_cart_room_id = array();
        $i=0;
        foreach(session()->get('cart_room_id') as $value) {
            $arr_cart_room_id[$i] = $value;
            $i++;
        }

        $arr_cart_checkin_date = array();
        $i=0;
        foreach(session()->get('cart_checkin_date') as $value) {
            $arr_cart_checkin_date[$i] = $value;
            $i++;
        }

        $arr_cart_checkout_date = array();
        $i=0;
        foreach(session()->get('cart_checkout_date') as $value) {
            $arr_cart_checkout_date[$i] = $value;
            $i++;
        }

        $arr_cart_adult = array();
        $i=0;
        foreach(session()->get('cart_adult') as $value) {
            $arr_cart_adult[$i] = $value;
            $i++;
        }

        $arr_cart_children = array();
        $i=0;
        foreach(session()->get('cart_children') as $value) {
            $arr_cart_children[$i] = $value;
            $i++;
        }

        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_adult');
        session()->forget('cart_children');

        for($i=0;$i<count($arr_cart_room_id);$i++)
        {
            if($arr_cart_room_id[$i] == $id) 
            {
                continue;    
            }
            else
            {
                session()->push('cart_room_id',$arr_cart_room_id[$i]);
                session()->push('cart_checkin_date',$arr_cart_checkin_date[$i]);
                session()->push('cart_checkout_date',$arr_cart_checkout_date[$i]);
                session()->push('cart_adult',$arr_cart_adult[$i]);
                session()->push('cart_children',$arr_cart_children[$i]);
            }
        }

        return redirect()->back()->with('success', 'Cart item is deleted.');

    }


    public function checkout()
    {
        if(!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }

        if(!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        return view('front.checkout');
    }

    public function payment(Request $request)
    {
        if(!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must have to login in order to checkout');
        }

        if(!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There is no item in the cart');
        }

        $request->validate([
            'billing_name' => 'required',
            'billing_email' => 'required|email',
            'billing_phone' => 'required',
            'billing_country' => 'required',
            'billing_address' => 'required',
            'billing_state' => 'required',
            'billing_city' => 'required',
            'billing_zip' => 'required'
        ]);

        session()->put('billing_name',$request->billing_name);
        session()->put('billing_email',$request->billing_email);
        session()->put('billing_phone',$request->billing_phone);
        session()->put('billing_country',$request->billing_country);
        session()->put('billing_address',$request->billing_address);
        session()->put('billing_state',$request->billing_state);
        session()->put('billing_city',$request->billing_city);
        session()->put('billing_zip',$request->billing_zip);

        return view('front.payment');
    }

    public function stripe(Request $request, $final_price)
{
    $stripe_secret_key = 'sk_test_51LT28GF67T3XLjgL8ICWowviN9gL7cXzOr1hPOEVX94aizsO58jdO1CtIBpo583748yVPzAV46pivFolrjqZddSx00PSAfpyff';

    // Mengonversi harga akhir ke sen (cents), 1 IDR = 1 sen
    $cents = $final_price * 100;

    // Tentukan batas maksimal jumlah yang diterima oleh Stripe untuk IDR
    $max_amount = 999999999; // Batas maksimal untuk transaksi IDR (999,999.99 IDR dalam sen)
    if ($cents > $max_amount) {
        $cents = $max_amount;  // Membatasi jumlah ke batas maksimal
    }

    Stripe\Stripe::setApiKey($stripe_secret_key);

    try {
        $response = Stripe\Charge::create([
            "amount" => $cents, // Jumlah dalam sen
            "currency" => "idr", // Mata uang IDR
            "source" => $request->stripeToken,
            "description" => env('APP_NAME')
        ]);
    } catch (\Exception $e) {
        return back()->withError('Payment failed: ' . $e->getMessage());
    }

    $responseJson = $response->jsonSerialize();
    $transaction_id = $responseJson['balance_transaction'];
    $last_4 = $responseJson['payment_method_details']['card']['last4'];

        $order_no = time();

        $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
        $ai_id = $statement[0]->Auto_increment;

        $obj = new Order();
        $obj->customer_id = Auth::guard('customer')->user()->id;
        $obj->order_no = $order_no;
        $obj->transaction_id = $transaction_id;
        $obj->payment_method = 'Stripe';
        $obj->card_last_digit = $last_4;
        $obj->paid_amount = $final_price;
        $obj->booking_date = date('d/m/Y');
        $obj->status = 'Completed';
        $obj->save();
        
        $arr_cart_room_id = array();
        $i=0;
        foreach(session()->get('cart_room_id') as $value) {
            $arr_cart_room_id[$i] = $value;
            $i++;
        }

        $arr_cart_checkin_date = array();
        $i=0;
        foreach(session()->get('cart_checkin_date') as $value) {
            $arr_cart_checkin_date[$i] = $value;
            $i++;
        }

        $arr_cart_checkout_date = array();
        $i=0;
        foreach(session()->get('cart_checkout_date') as $value) {
            $arr_cart_checkout_date[$i] = $value;
            $i++;
        }

        $arr_cart_adult = array();
        $i=0;
        foreach(session()->get('cart_adult') as $value) {
            $arr_cart_adult[$i] = $value;
            $i++;
        }

        $arr_cart_children = array();
        $i=0;
        foreach(session()->get('cart_children') as $value) {
            $arr_cart_children[$i] = $value;
            $i++;
        }

        for($i=0;$i<count($arr_cart_room_id);$i++)
        {
            $r_info = Room::where('id',$arr_cart_room_id[$i])->first();
            $d1 = explode('/',$arr_cart_checkin_date[$i]);
            $d2 = explode('/',$arr_cart_checkout_date[$i]);
            $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
            $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
            $t1 = strtotime($d1_new);
            $t2 = strtotime($d2_new);
            $diff = ($t2-$t1)/60/60/24;
            $sub = $r_info->price*$diff;

            $obj = new OrderDetail();
            $obj->order_id = $ai_id;
            $obj->room_id = $arr_cart_room_id[$i];
            $obj->order_no = $order_no;
            $obj->checkin_date = $arr_cart_checkin_date[$i];
            $obj->checkout_date = $arr_cart_checkout_date[$i];
            $obj->adult = $arr_cart_adult[$i];
            $obj->children = $arr_cart_children[$i];
            $obj->subtotal = $sub;
            $obj->save();

            while(1) {
                if($t1>=$t2) {
                    break;
                }

                $obj = new BookedRoom();
                $obj->booking_date = date('d/m/Y',$t1);
                $obj->order_no = $order_no;
                $obj->room_id = $arr_cart_room_id[$i];
                $obj->save();

                $t1 = strtotime('+1 day',$t1);
            }

        }

        $subject = 'New Order';
        $message = 'You have made an order for hotel booking. The booking information is given below: <br>';
        $message .= '<br>Order No: '.$order_no;
        $message .= '<br>Transaction Id: '.$transaction_id;
        $message .= '<br>Payment Method: Stripe';
        $message .= '<br>Paid Amount: '.$final_price;
        $message .= '<br>Booking Date: '.date('d/m/Y').'<br>';

        for($i=0;$i<count($arr_cart_room_id);$i++) {

            $r_info = Room::where('id',$arr_cart_room_id[$i])->first();

            $message .= '<br>Room Name: '.$r_info->name;
            $message .= '<br>Price Per Night: $'.$r_info->price;
            $message .= '<br>Checkin Date: '.$arr_cart_checkin_date[$i];
            $message .= '<br>Checkout Date: '.$arr_cart_checkout_date[$i];
            $message .= '<br>Adult: '.$arr_cart_adult[$i];
            $message .= '<br>Children: '.$arr_cart_children[$i].'<br>';
        }            

        $customer_email = Auth::guard('customer')->user()->email;


        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_adult');
        session()->forget('cart_children');
        session()->forget('billing_name');
        session()->forget('billing_email');
        session()->forget('billing_phone');
        session()->forget('billing_country');
        session()->forget('billing_address');
        session()->forget('billing_state');
        session()->forget('billing_city');
        session()->forget('billing_zip');

        return redirect()->route('customer_order_view')->with('success', 'Payment is successful, please upload your payment proof!');


    }
    public function cashPayment()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->back()->with('error', 'You must be logged in to complete the booking.');
        }
    
        if (!session()->has('cart_room_id')) {
            return redirect()->back()->with('error', 'There are no items in your cart.');
        }
    
        $order_no = time();
        $statement = DB::select("SHOW TABLE STATUS LIKE 'orders'");
        $ai_id = $statement[0]->Auto_increment;
    
        $total_price = 0;
    
        // Insert Order
        $order = new Order();
        $order->customer_id = Auth::guard('customer')->user()->id;
        $order->order_no = $order_no;
        $order->transaction_id = $order_no . '-CASH'; // Cash does not have a transaction ID
        $order->payment_method = 'Cash';
        $order->card_last_digit = null; // Not applicable for cash
        $order->paid_amount = 0; // Optional: set it to 0 or calculate later
        $order->booking_date = date('d/m/Y');
        $order->status = 'Pending'; // Mark as pending for cash
        $order->save();
    
        // Cart Data
        $cart_room_ids = session()->get('cart_room_id');
        $cart_checkin_dates = session()->get('cart_checkin_date');
        $cart_checkout_dates = session()->get('cart_checkout_date');
        $cart_adults = session()->get('cart_adult');
        $cart_children = session()->get('cart_children');
    
        for ($i = 0; $i < count($cart_room_ids); $i++) {
            $room = Room::find($cart_room_ids[$i]);
            $d1 = explode('/', $cart_checkin_dates[$i]);
            $d2 = explode('/', $cart_checkout_dates[$i]);
            $d1_new = $d1[2] . '-' . $d1[1] . '-' . $d1[0];
            $d2_new = $d2[2] . '-' . $d2[1] . '-' . $d2[0];
            $t1 = strtotime($d1_new);
            $t2 = strtotime($d2_new);
            $diff = ($t2 - $t1) / 60 / 60 / 24;
            $sub_total = $room->price * $diff;
            $total_price += $sub_total;
    
            // Insert Order Detail
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $ai_id;
            $orderDetail->room_id = $cart_room_ids[$i];
            $orderDetail->order_no = $order_no;
            $orderDetail->checkin_date = $cart_checkin_dates[$i];
            $orderDetail->checkout_date = $cart_checkout_dates[$i];
            $orderDetail->adult = $cart_adults[$i];
            $orderDetail->children = $cart_children[$i];
            $orderDetail->subtotal = $sub_total;
            $orderDetail->save();
    
            // Mark Room as Booked
            while ($t1 < $t2) {
                $bookedRoom = new BookedRoom();
                $bookedRoom->booking_date = date('d/m/Y', $t1);
                $bookedRoom->order_no = $order_no;
                $bookedRoom->room_id = $cart_room_ids[$i];
                $bookedRoom->save();
                $t1 = strtotime('+1 day', $t1);
            }
        }
    
        // Update order with total price
        $order->paid_amount = $total_price;
        $order->save();
    
        // Clear Cart
        session()->forget('cart_room_id');
        session()->forget('cart_checkin_date');
        session()->forget('cart_checkout_date');
        session()->forget('cart_adult');
        session()->forget('cart_children');
    
        return redirect('/')->with('success', 'Booking is completed successfully. Payment method: Cash.');
    }
    
    }
