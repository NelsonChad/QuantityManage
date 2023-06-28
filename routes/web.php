<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth'], 'namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/association', [App\Http\Controllers\admin\AssociationController::class, 'index'])->name('association');
    Route::post('/associate', [App\Http\Controllers\admin\AssociationController::class, 'store'])->name('admin.associate.store');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

