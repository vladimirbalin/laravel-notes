<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
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

Route::get('/', [HomeController::class, 'index']);

Route::post('register', [LoginController::class, 'register'])->name('register');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [LoginController::class, 'user'])->name('user');

    Route::apiResource('notes', NoteController::class)
        ->only(['index', 'store', 'update', 'destroy']);
});
