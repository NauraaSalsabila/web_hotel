@extends('front.layout.app')

@section('main_content')
<!-- Page Top Section -->
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Featured Posts</h2>
            </div>
        </div>
    </div>
</div>

<!-- AddThis Social Share Widget Script -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6212352ed76fda0a"></script>

<!-- Main Content Section -->
<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">

            <!-- Carousel for Images -->
            <div id="postCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- First Image -->
                    <div class="carousel-item active">
                        <!-- Title above the image -->
                        <div class="text-center">
                            <h2>Post 1: Image 5</h2>
                        </div>
                        <!-- Image itself -->
                        <img src="{{ asset('uploads/2.jpg') }}" class="d-block w-100" alt="Image 5">
                        <!-- Description below the image -->
                        <div class="text-center mt-3">
                            <p>This is the description for the first image. You can add any custom content here for the first post.</p>
                        </div>
                    </div>
                    <!-- Second Image -->
                    <div class="carousel-item">
                        <!-- Title above the image -->
                        <div class="text-center">
                            <h2>Post 2: Image 6</h2>
                        </div>
                        <!-- Image itself -->
                        <img src="{{ asset('uploads/6.jpg') }}" class="d-block w-100" alt="Image 6">
                        <!-- Description below the image -->
                        <div class="text-center mt-3">
                            <p>This is the description for the second image. Customize the text for the second post as needed.</p>
                        </div>
                    </div>
                    <!-- Third Image -->
                    <div class="carousel-item">
                        <!-- Title above the image -->
                        <div class="text-center">
                            <h2>Post 3: Image 7</h2>
                        </div>
                        <!-- Image itself -->
                        <img src="{{ asset('uploads/7.jpg') }}" class="d-block w-100" alt="Image 7">
                        <!-- Description below the image -->
                        <div class="text-center mt-3">
                            <p>This is the description for the third image. Feel free to replace the content with whatever you need.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#postCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
    </div>
</div>

@endsection