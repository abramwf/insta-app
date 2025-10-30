<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index() {}
    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'username' => 'required|max:255|unique:users,username,' . $user->id,
            'avatar' => 'file|nullable|max:2000'
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back();
    }
}
