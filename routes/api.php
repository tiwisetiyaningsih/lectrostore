<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\FavoriteProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
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

//public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/banks', [BankAdminController::class, 'index']);
Route::get('/banks/{id}', [BankAdminController::class, 'show']);
Route::get('/catproduct', [ProductCategoryController::class, 'index']);
Route::get('/catproduct/{id}', [ProductCategoryController::class, 'show']);


//protacted route
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/banks/{id}', [BankAdminController::class, 'store']);
    Route::get('/banks', [BankAdminController::class, 'index']);
    Route::get('/banks/{id}', [BankAdminController::class, 'show']);
    Route::put('/banks/{id}/{id_user}', [BankAdminController::class, 'update']);
    Route::delete('/banks/{id}/{id_user}', [BankAdminController::class, 'destroy']);
    Route::post('/catproduct/{id}', [ProductCategoryController::class, 'store']);
    Route::get('/catproduct', [ProductCategoryController::class, 'index']);
    Route::get('/catproduct/{id}', [ProductCategoryController::class, 'show']);
    Route::put('/catproduct/{id}/{id_user}', [ProductCategoryController::class, 'update']);
    Route::delete('/catproduct/{id}/{id_user}', [ProductCategoryController::class, 'destroy']);
    Route::post('/product/{id}', [ProductController::class, 'store']);
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/productbycat/{id}', [ProductController::class, 'show']);
    Route::get('/search_product/{name_product}', [ProductController::class, 'searchproduct']);
    Route::put('/product/{id}/{id_user}', [ProductController::class, 'update']);
    Route::delete('/product/{id}/{id_user}', [ProductController::class, 'destroy']);
    Route::post('/chart', [ChartController::class, 'store']);
    Route::get('/chart/{id_user}', [ChartController::class, 'showbyiduser']);
    Route::put('/chart/{id}/{id_user}', [ChartController::class, 'update']);
    Route::delete('/chart/{id}/{id_user}', [ChartController::class, 'destroy']);
    Route::post('/favorite', [FavoriteProductController::class, 'store']);
    Route::get('/favorite/{id}', [FavoriteProductController::class, 'show']);
    Route::post('/banks/{id}', [BankAdminController::class, 'store']);
    Route::get('/banks', [BankAdminController::class, 'index']);
    Route::get('/banks/{id}', [BankAdminController::class, 'show']);
    Route::put('/banks/{id}/{id_user}', [BankAdminController::class, 'update']);
    Route::delete('/banks/{id}/{id_user}', [BankAdminController::class, 'destroy']);
    Route::resource('banks', BankAdminController::class)->except('create', 'edit', 'show', 'index');
    Route::resource('catproduct', ProductCategoryController::class)->except('create', 'edit', 'show', 'index');

});
