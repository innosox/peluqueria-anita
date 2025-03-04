<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AttentionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/clientes', CustomerController::class);
    Route::apiResource('/citas', AppointmentController::class);
    Route::apiResource('/atenciones', AttentionController::class);
});


