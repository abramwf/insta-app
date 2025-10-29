<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('likes')->with(['comments.user:id,username,avatar', 'user:id,username,avatar'])->get()->map(function ($post) {
            $post->is_liked = $post->isLikedBy(auth()->user());
            return $post;
        });


        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }
}
