<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);
        $data['user_id'] = auth()->id();


        Comment::create($data);

        return back();
    }
}
