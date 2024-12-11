<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $post_all = Post::orderBy('id','desc')->limit(3)->get();
        $room_all = Room::get();

        return view('front.home', compact('post_all','room_all'));
    }
}
