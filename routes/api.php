<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::post('register', [LoginController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [LoginController::class, 'user']);

    Route::apiResource('notes', NoteController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::delete('logout', [LoginController::class, 'logout']);
});

