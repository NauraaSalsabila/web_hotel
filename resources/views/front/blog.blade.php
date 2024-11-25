@extends('front.layout.app')

@section('main_content')
<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $global_page_data->blog_heading }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="blog-item">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <!-- Display images from public/uploads/ -->
                        <img src="{{ asset('uploads/2.jpg') }}" alt="Image 5">
                    </div>
                    <div class="text">
                        <h2>Image 5</h2>
                        <p>astaghfirullah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <!-- Display images from public/uploads/ -->
                        <img src="{{ asset('uploads/6.jpg') }}" alt="Image 6">
                    </div>
                    <div class="text">
                        <h2>Image 6</h2>
                        <p>astaghfirullah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="inner">
                    <div class="photo">
                        <!-- Display images from public/uploads/ -->
                        <img src="{{ asset('uploads/7.jpg') }}" alt="Image 7">
                    </div>
                    <div class="text">
                        <h2>Image 7</h2>
                        <p>astaghfirullah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection