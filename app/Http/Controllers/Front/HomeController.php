<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Feature;
use App\Models\Testimonial;
use App\Models\Post;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $slide_all = Slide::get();
        $feature_all = Feature::get();
        $testimonial_all = Testimonial::get();
        $post_all = [
            [
                'id' => 1,
                'photo' => 'post1.jpg',
                'heading' => 'Post Title 1',
                'short_content' => 'This is a short description of the first post.'
            ],
            [
                'id' => 2,
                'photo' => 'post2.jpg',
                'heading' => 'Post Title 2',
                'short_content' => 'This is a short description of the second post.'
            ],
            [
                'id' => 3,
                'photo' => 'post3.jpg',
                'heading' => 'Post Title 3',
                'short_content' => 'This is a short description of the third post.'
            ],
            // Add more posts as needed
        ];

        $room_all = Room::get();

        return view('front.home', compact('slide_all','feature_all','testimonial_all','post_all','room_all'));
    }
}