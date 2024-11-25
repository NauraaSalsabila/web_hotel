<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;  // Import the Post model here
use File;

class BlogController extends Controller
{
    public function index()
    {
        // Fetch the latest 3 posts without pagination
        $post_all = Post::orderBy('id', 'desc')->take(3)->get();

        // Get all image files in the 'public/uploads' folder
        $imageFiles = File::allFiles(public_path('uploads'));

        // Assign a random image to each post
        foreach ($post_all as $item) {
            $randomImage = $imageFiles[array_rand($imageFiles)];  // Pick a random image
            $item->photo = 'uploads/' . basename($randomImage);  // Set the photo attribute
        }

        return view('front.blog', compact('post_all'));
    }

    public function single_post($id)
    {
        // Fetch the single post data by ID
        $single_post_data = Post::where('id', $id)->first();

        // Check if the post exists
        if (!$single_post_data) {
            return redirect()->route('blog.index')->with('error', 'Post not found');
        }

        // Increment the view count
        $single_post_data->total_view = $single_post_data->total_view + 1;
        $single_post_data->update();

        return view('front.post', compact('single_post_data'));
    }
}