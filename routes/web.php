<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use Illuminate\Support\Facades\DB;


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', function () {
    $brands = DB::table('brands')->get();
    return view('home', compact('brands'));
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/index', [ContactController::class, 'index'])->name('conn');

/////        CATEGORY ROUTE       /////

Route::get('/categoty/all', [CategoryController::class, 'allCategory'])->name('all.category');
Route::post('/categoty/add', [CategoryController::class, 'addCategory'])->name('store.category');

Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory']);
Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory']);
Route::get('/category/softDelete/{id}', [CategoryController::class, 'softDelete']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restoreCategory']);
Route::get('/category/clear/{id}', [CategoryController::class, 'clearCategory']);

/////        BRAND ROUTE        /////

Route::get('/brand/all', [BrandController::class, 'allBrand'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'addBrand'])->name('add.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'editBrand']);
Route::post('/brand/update/{id}', [BrandController::class, 'updateBrand']);
Route::get('/brand/delete/{id}', [BrandController::class, 'deleteBrand']);

/////      Multiple Image Route    /////

Route::get('/multiple-image', [BrandController::class, 'multipleImage'])->name('multi.image');
Route::post('/multiple-image/create', [BrandController::class, 'addMultipleImage'])->name('multiple-image.add');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // $users = User::all();
    // $users = DB::table('users')->get();
    return view('admin.index');
})->name('dashboard');

Route::get('/user/logout', [BrandController::class, 'Logout'])->name('user.logout');
