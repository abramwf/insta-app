<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;


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
    Route::get('/', function () {
        return Inertia::render('Home');
    })->name('home');
    Route::get('/profile', function () {
        return Inertia::render('Profile');
    })->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
