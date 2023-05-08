<?php

use App\Http\Controllers\ApiController;
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

Route::post('login', [ApiController::class, 'login'])->name('api.login');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [ApiController::class, 'logout'])->name('api.logout');

    Route::post('ocr-image-upload', [ApiController::class, 'ocrImageUpload'])->name('api.ocr-image-upload');
    Route::post('ocr-result-save', [ApiController::class, 'ocrResultSave'])->name('api.ocr-result-save');
    Route::post('get-shop-list', [ApiController::class, 'getShopList'])->name('api.get-shop-list');
    Route::post('get-list-by-date', [ApiController::class, 'getListByDate'])->name('api.get-list-by-date');
    Route::post('get-month', [ApiController::class, 'getMonth'])->name('api.get-month');
    Route::post('get-list-total', [ApiController::class, 'getListTotal'])->name('api.get-list-total');
    Route::post('get-month-status', [ApiController::class, 'getMonthStatus'])->name('api.get-month-status');
});
