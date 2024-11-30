@extends('front.layout.app')

@section('main_content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->cart_heading }}</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <div class="container">
        <div class="row cart">
            <div class="col-md-12">
                @if(session()->has('cart_room_id'))

                <div class="table-responsive">
                    <table class="table table-bordered table-cart">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Serial</th>
                                <th>Photo</th>
                                <th>Room Info</th>
                                <th>Price/Night</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Guests</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                            $arr_cart_room_id = session()->get('cart_room_id', []);
                            $arr_cart_checkin_date = session()->get('cart_checkin_date', []);
                            $arr_cart_checkout_date = session()->get('cart_checkout_date', []);
                            $arr_cart_adult = session()->get('cart_adult', []);
                            $arr_cart_children = session()->get('cart_children', []);
                            
                            $total_price = 0;
                            @endphp

                            @foreach($arr_cart_room_id as $i => $room_id)
                                @php
                                    $room_data = DB::table('rooms')->where('id', $room_id)->first();

                                    // Ensure valid check-in and check-out dates are set
                                    $checkin_date = isset($arr_cart_checkin_date[$i]) ? $arr_cart_checkin_date[$i] : null;
                                    $checkout_date = isset($arr_cart_checkout_date[$i]) ? $arr_cart_checkout_date[$i] : null;
                                    $adult_count = isset($arr_cart_adult[$i]) ? $arr_cart_adult[$i] : 0;
                                    $children_count = isset($arr_cart_children[$i]) ? $arr_cart_children[$i] : 0;

                                    // Check if both dates are set and valid
                                    if ($checkin_date && $checkout_date) {
                                        $d1 = explode('/', $checkin_date);
                                        $d2 = explode('/', $checkout_date);

                                        // Validate if the date arrays are not empty
                                        if (count($d1) == 3 && count($d2) == 3) {
                                            $d1_new = $d1[2].'-'.$d1[1].'-'.$d1[0];
                                            $d2_new = $d2[2].'-'.$d2[1].'-'.$d2[0];
                                            $t1 = strtotime($d1_new);
                                            $t2 = strtotime($d2_new);
                                            $diff = ($t2 - $t1) / 60 / 60 / 24;
                                            $subtotal = $room_data->price * $diff;
                                        } else {
                                            $subtotal = 0;
                                        }
                                    } else {
                                        $subtotal = 0;
                                    }

                                    $total_price += $subtotal;
                                @endphp

                                <tr>
                                    <td>
                                        <a href="{{ route('cart_delete', $room_id) }}" class="cart-delete-link" onclick="return confirm('Are you sure?');"><i class="fa fa-times"></i></a>
                                    </td>
                                    <td>{{ $i + 1 }}</td>
                                    <td><img src="{{ asset('uploads/'.$room_data->featured_photo) }}"></td>
                                    <td>
                                        <a href="{{ route('room_detail', $room_data->id) }}" class="room-name">{{ $room_data->name }}</a>
                                    </td>
                                    <td>Rp{{ number_format($room_data->price, 0, ',', '.') }}</td>
                                    <td>{{ $checkin_date }}</td>
                                    <td>{{ $checkout_date }}</td>
                                    <td>
                                        Adult: {{ $adult_count }}<br>
                                        Children: {{ $children_count }}
                                    </td>
                                    <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td colspan="8" class="tar">Total:</td>
                                <td>Rp{{ number_format($total_price, 0, ',', '.') }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="checkout mb_20">
                    <a href="{{ route('checkout') }}" class="btn btn-primary bg-website">Checkout</a>
                </div>

                @else

                <div class="text-danger mb_30">
                    Cart is empty!
                </div>

                @endif

            </div>
        </div>
    </div>
</div>
@endsection