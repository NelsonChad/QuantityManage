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
Route::get('/get-months', [ManageController::class, 'getMonths']);
Route::get('/get-products', [ManageController::class, 'getProducts']);
Route::post('/store-publication', [ManageController::class, 'storePublication']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user-data', [ManageController::class, 'getUserData'])->middleware('auth:api');
});

/*Route::group(['middleware' => ['auth'], 'namespace' => 'Auth'], function () {

});*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
