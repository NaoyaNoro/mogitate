<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'products'],function(){
    Route::get('', [ProductController::class, 'index']);
    Route::get('register', [ProductController::class, 'register']);
    Route::post('register', [ProductController::class, 'add']);
    Route::get('{id}', [ProductController::class, 'detail']);
    Route::post('search', [ProductController::class, 'search']);
    Route::post('sort', [ProductController::class, 'sort']);
    Route::patch('{id}/update', [ProductController::class, 'update']);
    Route::delete('{id}/delete', [ProductController::class, 'destroy']);
});
