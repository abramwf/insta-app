<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['comments.user:id,username,avatar', 'user:id,username,avatar'])->get();


        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }
}
