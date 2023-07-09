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
//Route::group(['middleware' => ['auth'], 'namespace' => 'admin', 'prefix' => 'admin'], function () {});

Route::group(['middleware' => ['auth'], 'namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/association', [App\Http\Controllers\admin\AssociationController::class, 'index'])->name('association');
    Route::get('/all', [App\Http\Controllers\admin\ReportsController::class, 'getUsersOfProducts'])->name('general.products');
    Route::post('/associate', [App\Http\Controllers\admin\AssociationController::class, 'store'])->name('admin.associate.store');
    Route::get('/dessociate/{id}', [App\Http\Controllers\admin\AssociationController::class, 'removeAttach'])->name('admin.associate.self.remove');
    Route::post('/new-year', [App\Http\Controllers\admin\AssociationController::class, 'storeYear'])->name('admin.year.store');
    Route::get('/delete-year/{id}', [App\Http\Controllers\admin\AssociationController::class, 'yearDestroy'])->name('admin.year.delete');

    Route::get('/manage', [App\Http\Controllers\admin\CompaniesManagementController::class, 'index'])->name('admin.manage');
    Route::get('/company/{id}', [App\Http\Controllers\admin\CompaniesManagementController::class, 'show'])->name('admin.companie.show');

    Route::post('/associate/{id}', [App\Http\Controllers\admin\CompaniesManagementController::class, 'store'])->name('admin.associate.company.store');
    Route::get('/dessociate/{userID}/{prodID}', [App\Http\Controllers\admin\CompaniesManagementController::class, 'removeAttach'])->name('admin.associate.remove');


});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

