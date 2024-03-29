<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageController;

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
Auth::routes();
Route::get('/get-months/{id}/{year}', [ManageController::class, 'getMonths']);
Route::get('/get-years', [ManageController::class, 'getYears']);
Route::get('/get-allmonths', [ManageController::class, 'getAllMonths']);
Route::get('/get-products/{id}/{year}', [ManageController::class, 'getProducts']);
Route::post('/store-publication/{id}', [ManageController::class, 'storePublication']);
Route::get('/get-allpublications', [App\Http\Controllers\ReportsController::class, 'getUsersOfProducts']);
Route::get('/total-months/{product}/{year}', [App\Http\Controllers\ReportsController::class, 'getTotalProducPerMonth']);

Route::get('/get-publications/{user_id}/{product_id}/{year}', [App\Http\Controllers\ReportsController::class, 'getPublications']);




Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});
