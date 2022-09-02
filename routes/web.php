<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();


Route::group(['middleware' => 'auth', 'prevent-back-history'], function () {
    //trigger daily notifications
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);

    //Role Routes
    Route::get('/role/view', [App\Http\Controllers\RoleController::class, 'view'])->middleware('can:View Role');
    Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'create'])->middleware('can:Add Role');
    Route::post('/role/store', [App\Http\Controllers\RoleController::class, 'store'])->middleware('can:Add Role');
    Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('can:Edit Role');
    Route::post('/role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('can:Edit Role');
    Route::get('/role/destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:Delete Role');
    Route::post('/role/role_check', [App\Http\Controllers\RoleController::class, 'role_check']);
    
    //User Routes
    Route::get('/user/view', [App\Http\Controllers\UserController::class, 'view'])->middleware('can:View User');
    Route::get('/user/add', [App\Http\Controllers\UserController::class, 'create'])->middleware('can:Add User');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:Add User');
    Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->middleware('can:Edit User');
    Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:Edit User');
    Route::get('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:Delete User');
});