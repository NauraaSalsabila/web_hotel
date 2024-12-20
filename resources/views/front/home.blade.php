@extends('front.layout.app')

@section('main_content')
<div class="slider">
    <div class="slide-carousel owl-carousel">
        <!-- First Slide -->
        <div class="item" style="background-image:url({{ asset('uploads/slide1.jpg') }});">
            <div class="bg"></div>
            <div class="text">
                <h2>BEST HOTEL IN BANDAR LAMPUNG</h2>
                <p>Experience unparalleled luxury and world-class service at our premier hotel in Bandar Lampung. Offering a blend of modern amenities and traditional hospitality, we ensure an unforgettable stay for all our guests. Whether you're visiting for business or leisure, our location and facilities cater to all your needs.</p>
            </div>
        </div>

        <!-- Second Slide -->
        <div class="item" style="background-image:url({{ asset('uploads/slide2.jpg') }});">
            <div class="bg"></div>
            <div class="text">
                <h2>QUALITY ROOM FOR THE GUEST</h2>
                <p>Relax and rejuvenate in our meticulously designed rooms, tailored for your comfort. Each room is equipped with top-of-the-line amenities and offers breathtaking views, ensuring a peaceful and restful stay. Whether you're here for a short getaway or an extended visit, our rooms offer the perfect retreat after a long day.</p>
            </div>
        </div>
    </div>
</div>


<div class="search-section">
    <div class="container">
        <form action="{{ route('cart_submit') }}" method="post">
            @csrf
            <div class="inner">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <select name="room_id" class="form-select">
                                <option value="">Select Room</option>
                                @foreach($room_all as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="form-group position-relative">
                        <input type="text" name="checkin_checkout" class="form-control daterange1" placeholder="Checkin & Checkout">
                        <i class="fas fa-calendar-alt position-absolute" style="top: 12px; right: 10px; font-size: 18px;"></i>
                    </div>
                </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="number" name="adult" class="form-control" min="1" max="30" placeholder="Adults">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <input type="number" name="children" class="form-control" min="0" max="30" placeholder="Children">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<div class="home-feature">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="inner">
                    <div class="icon"><i class="fa-solid fa-swimming-pool"></i></div>
                    <div class="text">
                        <h2>Swimming Pool</h2>
                        <p>
                            Enjoy a luxurious and relaxing swim in our well-maintained pool area.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inner">
                    <div class="icon"><i class="fa-solid fa-spa"></i></div>
                    <div class="text">
                        <h2>Spa & Wellness</h2>
                        <p>
                            Experience ultimate relaxation with our world-class spa services.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inner">
                    <div class="icon"><i class="fa-solid fa-utensils"></i></div>
                    <div class="text">
                        <h2>Gourmet Dining</h2>
                        <p>
                            Indulge in exquisite cuisines prepared by top chefs at our restaurant.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inner">
                    <div class="icon"><i class="fa-solid fa-wifi"></i></div>
                    <div class="text">
                        <h2>Free Wi-Fi</h2>
                        <p>
                            Stay connected with high-speed internet available throughout the property.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="home-rooms">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Rooms and Suites</h2>
            </div>
        </div>
        <div class="row">
            @foreach($room_all as $item)
            @if($loop->iteration > 4) <!-- Ubah batasan jumlah tampilan jika diperlukan -->
            @break
            @endif
            <div class="col-md-3">
                <div class="inner">
                    <div class="photo">
                        <img src="{{ asset('uploads/'.$item->featured_photo) }}" alt="">
                    </div>
                    <div class="text">
                        <h2><a href="{{ route('room_detail',$item->id) }}">{{ $item->name }}</a></h2>
                        <div class="price">
                            Rp{{ number_format($item->price, 0, ',', '.') }}/night
                        </div>

                        <div class="button">
                            <a href="{{ route('room_detail', $item->id) }}" class="btn btn-primary" style="border-radius: 10px; color: #2D6ADC; border-width: 2px;">See Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
            <div class="big-button">
                <a href="{{ route('room') }}" class="btn btn-primary custom-btn" style="border-radius: 10px;">See All Rooms</a>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="testimonial" style="background-image: url(uploads/slide2.jpg)">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Our Happy Clients</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="testimonial-carousel owl-carousel">
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/client1.png') }}" alt="Client 1">
                        </div>
                        <div class="text">
                            <h4>Jessen Ramadeksa Allen</h4>
                            <p>Entrepreneur</p>
                        </div>
                        <div class="description">
                            <p>
                                "This service exceeded my expectations. The team was professional and the process seamless."
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/client2.png') }}" alt="Client 2">
                        </div>
                        <div class="text">
                            <h4>Naura Salsabila</h4>
                            <p>Travel Blogger</p>
                        </div>
                        <div class="description">
                            <p>
                                "The experience was outstanding. Highly recommended for those seeking quality and reliability."
                            </p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="photo">
                            <img src="{{ asset('uploads/client3.png') }}" alt="Client 3">
                        </div>
                        <div class="text">
                            <h4>Dian Prinatama Silaban</h4>
                            <p>Software Engineer</p>
                        </div>
                        <div class="description">
                            <p>
                                "I’m very impressed with the attention to detail and the excellent customer service provided."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="blog-item">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="main-header">Latest Posts</h2>
            </div>
        </div>
        <div class="row">

            @foreach($post_all as $item)
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <img src="{{ asset('uploads/'.$item->photo) }}" alt="">
                    </div>
                    <div class="text">
                        <h2><a href="{{ route('post',$item->id) }}">{{ $item->heading }}</a></h2>
                        <div class="short-des">
                            <p>
                                {!! $item->short_content !!}
                            </p>
                        </div>
                        <div class="button">
                            <a href="{{ route('post',$item->id) }}" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>


@if($errors->any())
    @foreach($errors->all() as $error)
        <script>
            iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{ $error }}',
            });
        </script>
    @endforeach
@endif
@endsection