<?php

use App\Http\Controllers\NoteController;
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

Route::post('register', [\App\Http\Controllers\Auth\LoginController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::delete('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::apiResource('notes', NoteController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware('auth:sanctum');
