<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\ProductAccessMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RESTful routes products resource
Route::apiResource('products', 'ProductController');

// Route for uploading image using local disk
Route::post('products/upload/local', 'ProductController@uploadToLocal')->name('upload.local');

// Route for uploading image using public disk
Route::post('products/upload/public', 'ProductController@uploadToPublic')->name('upload.public');

Route::middleware([ProductAccessMiddleware::class])->group(function () {
    // Storing a new product
    Route::post('products', [ProductController::class, 'store']);

    // Updating an existing product
    Route::put('products/{id}', [ProductController::class, 'update']);

    // Deleting a product
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    // Uploading images
    Route::post('products/upload/local', [ProductController::class, 'uploadImageLocal']);
    Route::post('products/upload/public', [ProductController::class, 'uploadImagePublic']);
});