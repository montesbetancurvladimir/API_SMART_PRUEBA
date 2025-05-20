<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

// Rutas públicas
Route::post('user/login', [AuthController::class, 'login']);
Route::post('user/register', [AuthController::class, 'register']);  // Registro normal usuario (rol 'user')

// Accesibles para todos los usuarios autenticados con rol 'user'
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('user/logout', [AuthController::class, 'logout']);

    Route::post('/categories', [CategoryController::class, 'store']);
    // Solo para el rol 'admin'
    Route::middleware('role:admin')->group(function () {
        //Productos con rol 'admin'
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        //Categorias con rol 'admin'
  
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    });
});
