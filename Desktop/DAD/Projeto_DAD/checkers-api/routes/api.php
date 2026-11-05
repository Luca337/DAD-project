<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rotas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas (só para utilizadores com login feito)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Aqui vais adicionar depois as rotas para a carteira, perfil, etc.
    Route::get('/user', function (Illuminate\Http\Request $request) {
        return $request->user();
    });
});
