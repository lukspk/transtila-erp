<?php

use App\Http\Controllers\Api\V1\AnuncioChatController;
use App\Http\Controllers\Api\V1\AnuncioController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\CategoriaController;
use App\Http\Controllers\Api\V1\TipoController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('tipos', TipoController::class);
    Route::get('anuncios/recentes', [AnuncioController::class, 'anunciosRecentes']);
    Route::apiResource('anuncios', AnuncioController::class);

    // Route::apiResource('chats', AnuncioChatController::class);

    Route::prefix('chats')->controller(AnuncioChatController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/create', 'createOrGetChat');
        Route::post('/send/{id}', 'sendMessage');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me/anuncios', [AnuncioController::class, 'userAnuncios']);
        Route::get('/me', [LoginController::class, 'me']);
    });
});
