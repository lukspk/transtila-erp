<?php

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\CheckinController;
use App\Http\Controllers\Web\EntregaController;
use App\Http\Controllers\Web\FinanceiroController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

    Route::prefix('entregas')->name('entregas.')->middleware(['role:administrador'])->group(function () {
        Route::get('/', [EntregaController::class, 'index'])->name('index');
        Route::get('/create', [EntregaController::class, 'create'])->name('create');
        Route::get('/{entrega}', [EntregaController::class, 'show'])->name('show');
        Route::post('/', [EntregaController::class, 'store'])->name('store');
        Route::get('/{entrega}/edit', [EntregaController::class, 'edit'])->name('edit');
        Route::put('/{entrega}', [EntregaController::class, 'update'])->name('update');
        Route::delete('/{entrega}', [EntregaController::class, 'destroy'])->name('destroy');
        // Adiciona estas duas linhas junto às tuas outras rotas de entrega
        Route::get('/upload/create', [EntregaController::class, 'showUploadForm'])->name('upload.create');
        Route::post('/upload', [EntregaController::class, 'processarUpload'])->name('upload');
        Route::post('/entregas/{entrega}/contas', [EntregaController::class, 'storeAjax'])->name('contas.store.ajax');
        Route::delete('/entregas/contas/{id}', [EntregaController::class, 'deletarConta'])->name('contas.delete.ajax');
    });


    Route::prefix('financeiro')->name('financeiro.')->middleware(['role:administrador'])->group(function () {
        Route::get('/', [FinanceiroController::class, 'index'])->name('index');
        Route::get('/create', [FinanceiroController::class, 'create'])->name('create');
        Route::post('/', [FinanceiroController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [FinanceiroController::class, 'deletarConta'])->name('delete');
        Route::get('/{financeiro}', [FinanceiroController::class, 'showDetail'])->name('show.detail');
        Route::patch('/parcela/{parcela}/pagar', [FinanceiroController::class, 'pagar'])->name('parcela.pagar');
    });


    Route::get('/t/{entregaHash}/{motoristaHash}', [CheckinController::class, 'showCheckinPage'])->name('checkin.show');

    Route::post('/checkin', [CheckinController::class, 'storeCheckin'])->name('checkin.store');



    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

// Route::get('/', function () {
//     return 'Bem-vindo, Administrador!';
// })->middleware(['auth', 'role:admin']);

// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
// });


//Route::get('/', fn() => view('dashboard'))->name('admin.index-light');
