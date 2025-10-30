<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register.index');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', function () {
        return Inertia::render('Profile');
    })->name('profile');
    Route::get('/post/create', function () {
        return Inertia::render('Post');
    })->name('post.create');

    Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
    Route::put('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/post/{post}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
