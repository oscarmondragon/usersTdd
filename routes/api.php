<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
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

//Auth routes
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::post('refresh', [LoginController::class, 'refresh'])->name('auth.refresh');
    Route::post('me', [LoginController::class, 'me'])->name('auth.me');

});

Route::middleware('auth:api')->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('user.create');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');



});

