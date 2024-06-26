<?php

use App\Http\Controllers\User\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('user/login', [AuthController::class, 'login']);

Route::post('user/register', [AuthController::class, 'register']);
