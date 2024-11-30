<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
        <meta name="description" content="">
        <title>Hotel Website</title>        
		
        <link rel="icon" type="image/png" href="{{ asset('uploads/'.$global_setting_data->favicon) }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        @include('front.layout.styles')

        @include('front.layout.scripts')        
        

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500&display=swap" rel="stylesheet">
        
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $global_setting_data->analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $global_setting_data->analytic_id }}');
        </script>

<style>
    /* Warna Utama - Biru dan Putih */
    :root {
        --primary-color: #2196F3; /* Biru */
        --secondary-color: #ffffff; /* Putih */
        --hover-color: #0d47a1; /* Biru lebih gelap untuk hover */
        --border-color: #2196F3; /* Warna border biru */
    }

    /* Navigation Hover Effects */
    .main-nav nav .navbar-nav .nav-item a:hover,
    .main-nav nav .navbar-nav .nav-item:hover a,
    .slide-carousel.owl-carousel .owl-nav .owl-prev:hover, 
    .slide-carousel.owl-carousel .owl-nav .owl-next:hover,
    .home-feature .inner .icon i,
    .home-rooms .inner .text .price,
    .home-rooms .inner .text .button a,
    .blog-item .inner .text .button a,
    .room-detail-carousel.owl-carousel .owl-nav .owl-prev:hover, 
    .room-detail-carousel.owl-carousel .owl-nav .owl-next:hover {
        color: var(--primary-color);
        transition: color 0.3s ease;
        font-weight: bold;
    }

    /* Dropdown Hover Effects */
    .main-nav nav .navbar-nav .nav-item .dropdown-menu li a:hover,
    .primary-color {
        color: var(--primary-color)!important;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    /* Testimonial Carousel Dot Hover */
    .testimonial-carousel .owl-dots .owl-dot {
        background-color: var(--primary-color)!important;
        transition: background-color 0.3s ease;
    }

    .testimonial-carousel .owl-dots .owl-dot.active {
        background-color: var(--secondary-color)!important;
    }

    /* Footer and Buttons Styling */
    .footer input[type="submit"],
    .scroll-top,
    .room-detail .right .widget .book-now {
        background-color: var(--primary-color);
        border-radius: 50px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
        border: 2px solid var(--primary-color); /* Menambahkan border biru */
    }

    /* Hover Effect for Footer Links */
    .footer ul.social li a:hover,
    .footer input[type="submit"]:hover {
        background-color: var(--hover-color);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
        border-color: var(--hover-color); /* Border berubah saat hover */
    }

    /* Buttons with Hover Effect */
    .slider .text .button a,
    .search-section button[type="submit"],
    .home-rooms .big-button a,
    .bg-website {
        background-color: var(--primary-color)!important;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease, border-color 0.3s ease;
        border: 2px solid var(--primary-color); /* Menambahkan border biru */
    }

    /* Hover Effect for Buttons */
    .slider .text .button a:hover,
    .search-section button[type="submit"]:hover,
    .home-rooms .big-button a:hover,
    .bg-website:hover {
        background-color: var(--hover-color)!important;
        transform: translateY(-5px);
        border-color: var(--hover-color); /* Border berubah jadi biru lebih gelap saat hover */
    }

    /* Border Color Effects for Various Elements */
    .slider .text .button a,
    .slide-carousel.owl-carousel .owl-nav .owl-prev:hover, 
    .slide-carousel.owl-carousel .owl-nav .owl-next:hover,
    .search-section button[type="submit"],
    .room-detail-carousel.owl-carousel .owl-nav .owl-prev:hover, 
    .room-detail-carousel.owl-carousel .owl-nav .owl-next:hover,
    .room-detail .amenity .item {
        border-color: var(--border-color)!important;
        transition: border-color 0.3s ease;
        border-width: 2px; /* Menambahkan ketebalan border */
        border-style: solid; /* Menambahkan gaya border solid */
    }

    /* Hover Effect for Amenity Items */
    .room-detail .amenity .item:hover {
        background-color: var(--primary-color)!important;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-color: var(--hover-color); /* Border berubah menjadi biru gelap saat hover */
    }

    /* Background Color for Items */
    .home-feature .inner .icon i,
    .home-rooms .inner .text .button a,
    .blog-item .inner .text .button a,
    .room-detail .amenity .item,
    .cart .table-cart tr th {
        background-color: var(--secondary-color)!important;
        transition: background-color 0.3s ease;
        padding: 8px 15px;
        border-radius: 5px;
        border: 2px solid var(--border-color); /* Menambahkan border biru pada item */
    }

    /* Hover Effect for Items */
    .home-feature .inner .icon i:hover,
    .home-rooms .inner .text .button a:hover,
    .blog-item .inner .text .button a:hover,
    .room-detail .amenity .item:hover,
    .cart .table-cart tr th:hover {
        background-color: var(--primary-color)!important;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-color: var(--hover-color); /* Border berubah warna saat hover */
    }

    .footer-links a {
    color: #ffffff; /* Warna tautan putih */
    text-decoration: none; /* Menghilangkan garis bawah */
    transition: color 0.3s; /* Efek transisi saat hover */
}

    .footer-links a:hover {
        color: #ffc107; /* Warna saat hover */
    }

    .social-icon {
        color: #ffffff; /* Warna ikon sosial putih */
        font-size: 1.5rem; /* Ukuran ikon lebih besar */
        transition: color 0.3s; /* Efek transisi saat hover */
    }


    .footer-message {
        font-style: italic; /* Gaya teks miring untuk pesan */
        font-size: 1.2rem; /* Ukuran font lebih besar */
    }

    .footer-contact span {
        color: #ffffff; /* Warna teks kontak putih */
    }
    .footer-link {
        position: relative;
        display: inline-block;
        text-decoration: none; /* Menghapus garis bawah default */
        color: white; /* Sesuaikan warna sesuai kebutuhan */
    }

    .footer-link::after {
        content: '';
        display: block;
        width: 100%;
        height: 2px; /* Atur ketebalan garis */
        background-color: white; /* Warna garis */
        position: absolute;
        bottom: -4px; /* Atur jarak garis dari teks */
        left: 0;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .footer-link:hover::after {
        opacity: 1;
    }
    .footer-divider {
        border: none;
        border-top: 2px solid white; 
        margin: 10px 0; 
        width: 100%; 
    }
    .footer-copyright {
        text-transform: none; /* Tidak mengubah huruf */
        font-size: 0.9rem;
        color: #ccc;
        font-weight: 400;
        letter-spacing: 1px;
    }


    /* Mobile Responsiveness */
    @media (max-width: 767px) {
        .main-nav nav .navbar-nav .nav-item a {
            font-size: 14px;
            padding: 10px;
        }
        .footer ul.social li a,
        .footer input[type="submit"] {
            padding: 8px 16px;
        }
    }
</style>


    </head>
    <body>
        
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 left-side">
                        <ul>
                            <!-- Mengganti nilai dengan manual -->
                            <li class="phone-text">0822-6767-1268</li>
                            <li class="email-text">infokamar@gmail.com</li>
                        </ul>
                        </ul>
                    </div>
                    <div class="col-md-6 right-side">
                        <ul class="right">

                            @if($global_page_data->cart_status == 1)
                            <li class="menu"><a href="{{ route('cart') }}">{{ $global_page_data->cart_heading }} @if(session()->has('cart_room_id'))<sup>{{ count(session()->get('cart_room_id')) }}</sup>@endif</a></li>
                            @endif

                            @if($global_page_data->checkout_status == 1)
                            <li class="menu"><a href="{{ route('checkout') }}">{{ $global_page_data->checkout_heading }}</a></li>
                            @endif


                            @if(!Auth::guard('customer')->check())

                                @if($global_page_data->signup_status == 1)
                                <li class="menu"><a href="{{ route('customer_signup') }}">{{ $global_page_data->signup_heading }}</a></li>
                                @endif

                                @if($global_page_data->signin_status == 1)
                                <li class="menu"><a href="{{ route('customer_login') }}">{{ $global_page_data->signin_heading }}</a></li>
                                @endif

                            @else   

                            @if(Auth::guard('customer')->check())
                                <li class="menu"><a href="{{ route('customer_home') }}">History</a></li>
                                <li class="menu dropdown">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                        @if(Auth::guard('customer')->user()->photo == '')
                                            <img alt="image" src="{{ asset('uploads/default.png') }}" class="rounded-circle" style="width: 30px; height: 30px;">
                                        @else
                                            <img alt="image" src="{{ asset('uploads/'.Auth::guard('customer')->user()->photo) }}" class="rounded-circle" style="width: 30px; height: 30px;">
                                        @endif
                                        <span>{{ Auth::guard('customer')->user()->name }}</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('customer_profile') }}" class="dropdown-item has-icon">
                                            <i class="fa fa-user"></i> Edit Profile
                                        </a>
                                        <a href="{{ route('customer_logout') }}" class="dropdown-item has-icon text-danger">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </a>
                                    </div>
                                </li>
                            @endif

                            @endif


                        </ul>
                    </div>
                </div>
            </div>
        </div>


                <!-- Bagian logo di Mobile Navigation -->
        <div class="mobile-nav">
            <a href="index.html" class="logo">
                <img src="/uploads/Logo.png" alt="Logo">
            </a>
        </div>

        <!-- Bagian logo di Desktop Navigation -->
        <div class="main-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="/uploads/Logo.png" alt="Logo">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <!-- Daftar menu -->

            
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                                </li>



                                <li class="nav-item">
                                    <a href="javascript:void;" class="nav-link dropdown-toggle">Room & Suite</a>
                                    <ul class="dropdown-menu">
                                        @foreach($global_room_data as $item)
                                        <li class="nav-item">
                                            <a href="{{ route('room_detail',$item->id) }}" class="nav-link">{{ $item->name }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>


                                


                                @if($global_page_data->blog_status == 1)
                                <li class="nav-item">
                                    <a href="{{ route('blog') }}" class="nav-link">{{ $global_page_data->blog_heading }}</a>
                                </li>
                                @endif

                                @if($global_page_data->contact_status == 1)
                                <li class="nav-item">
                                    <a href="{{ route('contact') }}" class="nav-link">{{ $global_page_data->contact_heading }}</a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        
        @yield('main_content')


        <div class="footer bg-dark text-white py-5">
        <div class="container">
        <!-- Site Links -->
        <div class="row">
            <div class="col-md-12">
                <ul class="d-flex justify-content-center list-unstyled gap-4 footer-links">
                    <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                    @if($global_page_data->blog_status == 1)
                    <li><a href="{{ route('blog') }}" class="footer-link">{{ $global_page_data->blog_heading }}</a></li>
                    @endif
                    @if($global_page_data->contact_status == 1)
                    <li><a href="{{ route('contact') }}" class="footer-link">{{ $global_page_data->contact_heading }}</a></li>
                    @endif
                </ul>
                <hr class="footer-divider">
            </div>
        </div>

        <!-- Social Links and Message -->
        <div class="row mt-4">
            <!-- Social Links -->
            <div class="col-md-12 text-center">
            <ul class="social d-flex justify-content-center list-unstyled gap-3">
                    <li><a href="https://www.facebook.com/" class="social-icon text-white bg-danger rounded-circle d-flex align-items-center justify-content-center"><i class="fa fa-facebook-f"></i></a></li>
                    <li><a href="https://www.twitter.com/" class="social-icon rounded-circle"><i class="fa fa-twitter"></i></a></li>                   
                    <li><a href="https://www.linkedin.com/" class="social-icon rounded-circle"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="https://www.pinterest.com/" class="social-icon rounded-circle"><i class="fa fa-pinterest-p"></i></a></li>
                    <li>
                        <a href="https://www.youtube.com/" class="social-icon text-white bg-black rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/" class="social-icon text-white bg-black rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/" class="social-icon text-white bg-black rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fab fa-google-plus-g"></i>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Message -->
            <div class="col-md-12 text-center mt-3">
                <p class="footer-message">We always on Unila.</p>
            </div>
        </div>

        <!-- Contact -->
        <div class="footer-contact bg-dark text-white py-4">
    <div class="container text-center">
        <!-- Judul and Subtitle -->
        <h3 class="footer-title">We're based in Kedaton, Embung.</h3>
        <p class="footer-subtitle">We work with clients from all over. Get in touch with us!</p>

        <!-- Contact Information -->
        <div class="footer-info d-flex justify-content-center align-items-center flex-wrap gap-4 mt-3">
            <span class="d-flex align-items-center gap-2">
                <i class="fa fa-envelope text-danger"></i>
                <a href="mailto:info@alanterealestate.com" class="text-white text-decoration-none fw-bold">infokamar@gmail.com</a>
            </span>
            <span class="d-flex align-items-center gap-2">
                <i class="fa fa-phone text-light"></i>
                <span class="text-white">0822-6767-1268</span>
            </span>
            <span class="d-flex align-items-center gap-2">
                <i class="fa fa-home text-light"></i>
                <span class="text-white">
                    Bandar Lampung, 25 Sandwich Street, Lampung, 02360
                </span>
            </span>
        </div>
    </div>
</div>


        <!-- Copyright -->
        <div class="row mt-4">
    <hr class="footer-divider">
    <div class="col-md-12 text-center">
    <p class="footer-copyright">&copy; 2024 WebHotels. All Rights On Air.</p>
    </div>
</div>

</div>



     
        <div class="scroll-top">
            <i class="fa fa-angle-up"></i>
        </div>
		
        @include('front.layout.scripts_footer')

        @if(session()->get('error'))
            <script>
                iziToast.error({
                    title: '',
                    position: 'topRight',
                    message: '{{ session()->get('error') }}',
                });
            </script>
        @endif

        @if(session()->get('success'))
            <script>
                iziToast.success({
                    title: '',
                    position: 'topRight',
                    message: '{{ session()->get('success') }}',
                });
            </script>
        @endif

        
        <div id="loader"></div>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
   </body>
</html>