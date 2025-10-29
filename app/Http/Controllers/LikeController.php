<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Request $request, $postId)
    {
        $user = $request->user();

        $like = Like::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();
            return back();
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);

        return back();
    }
}
