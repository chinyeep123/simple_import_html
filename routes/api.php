<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ProductController;
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

Route::post('login', LoginController::class)->name('api.login');
Route::get('products/import/template/download', [ProductController::class, 'downloadTemplate'])->name('api.product.import.template.download');
Route::post('products/import', [ProductController::class, 'storeImport'])->name('api.product.import.store');
Route::resource('products', ProductController::class)->only('index');
