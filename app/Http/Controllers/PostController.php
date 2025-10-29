<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required|max:1000',
            'image_path' => 'required|file|max:3000',
        ]);
        $data['user_id'] = auth()->id();
        if ($request->hasFile('image_path')) {
            $data['image_path'] = Storage::disk('public')->put('posts', $request->image_path);
        }

        Post::create($data);

        return redirect()->route('home');
    }
}
