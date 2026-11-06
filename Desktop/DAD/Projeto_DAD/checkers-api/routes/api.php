<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\GameController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/wallet', [WalletController::class, 'myWallet']);

    Route::get('/wallet', [WalletController::class, 'myWallet']);
    Route::get('/my-games', [GameController::class, 'myHistory']); // Nova rota do histórico

    // ROTAS DE ADMINISTRAÇÃO
    // ROTAS DE ADMINISTRAÇÃO[cite: 3]
    // ROTAS DE ADMINISTRAÇÃO[cite: 3]
    Route::middleware([IsAdmin::class])->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'listUsers']);
        Route::get('/users/{id}', [AdminController::class, 'showUser']); // Rota para ver 1 utilizador
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']); // Rota para apagar utilizador
        
        Route::get('/audit', [AdminController::class, 'auditLedger']);
        Route::get('/metrics', [AdminController::class, 'getMetrics']);
    });
});