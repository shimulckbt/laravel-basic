<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::get('message', function () {
//     return response()->json([
//         'message' => 'welcome to laravel api'
//     ], 422);
// });


// Route::get('categories', [CategoryController::class, 'index']);
// Route::post('categories/store', [CategoryController::class, 'store']);

Route::resource('categories', CategoryController::class);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
