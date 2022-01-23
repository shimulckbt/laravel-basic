<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
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

Route::get('/categoty/all', [CategoryController::class, 'allCategory'])->name('all.category');
Route::post('/categoty/add', [CategoryController::class, 'addCategory'])->name('store.category');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = User::all();
    // $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');
