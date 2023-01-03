<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UniversalController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tinker', [ProductController::class, 'tinker'])->name('tinker');
Route::get('product', [ProductController::class, 'test'])->name('product');
Route::get('product-custom', [ProductController::class, 'testCustom'])->name('product-custom');

// Route::get('test',[AnaliticController::class,'test'])->name('test');
Route::get('client', [TestController::class, 'client'])->name('client');
Route::get('universal', [UniversalController::class, 'universal'])->name('universal');
Route::post('auth', [LiveController::class, 'auth'])->name('auth');

Route::post('get-analytics-data', [LiveController::class, 'getAnalytics'])->name('get-analytics-data');
Route::post('get-auth-url', [LiveController::class, 'getAuthUrl'])->name('get-auth-url');
Route::post('get-tokens-by-auth-code', [LiveController::class, 'getTokensByAuthCode'])->name('get-tokens-by-auth-code');


// Route::post('refresh',[LiveController::class,'refresh'])->name('refresh');

Route::prefix('ads/')->name('ads.')->group(function () {
    Route::post('get-auth-url', [AdsController::class, 'getAuthUrl'])->name('get-auth-url');
    Route::post('get-tokens-by-auth-code', [AdsController::class, 'getTokensByAuthCode'])->name('get-tokens-by-auth-code');
});
