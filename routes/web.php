<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Models\User;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/index', [ContactController::class, 'index'])->name('conn');
// Route::get('/contact', [ContactController::class, 'about']);
// Route::get('/contact', [ContactController::class, 'contact']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = User::all(); //Eloquent ORM

    // $users = DB::table('users')->get(); //Query Builder

    return view('dashboard', compact('users'));
})->name('dashboard');
