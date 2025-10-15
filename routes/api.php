<?php

use App\Http\Controllers\API\Home\HomeController;
use App\Http\Controllers\API\Product\ProductController;
use App\Http\Controllers\API\FAQ\FAQController;
use App\Http\Controllers\API\ContactUs\ContactUsController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->middleware('throttle:4,1')->group(function () {});

Route::prefix('v1')->middleware(['localization'])->group(function () {
    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/categories', [HomeController::class, 'categories']);
    Route::get('/addresses', [HomeController::class, 'addresses']);
    Route::prefix('products')->controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{product}', 'show');
    });
    Route::get('/faqs', [FAQController::class, 'index']);
    Route::post('/contact-us', [ContactUsController::class, 'store']);
});
