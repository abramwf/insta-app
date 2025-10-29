<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|max:255|unique:users',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
            'avatar' => 'file|nullable|max:1000'
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        User::create($data);

        return redirect()->route('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
