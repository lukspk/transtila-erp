<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn() => Auth::check() ? redirect()->route('dashboard') : redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('users')->name('users.')->middleware(['role:administrador'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');       // <-- edit
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/', function () {
//     return 'Bem-vindo, Administrador!';
// })->middleware(['auth', 'role:admin']);

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
// });


//Route::get('/', fn() => view('dashboard'))->name('admin.index-light');
