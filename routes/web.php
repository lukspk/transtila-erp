<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return 'Bem-vindo, Administrador!';
// })->middleware(['auth', 'role:admin']);

// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', function () {
//         return 'Bem-vindo, Administrador!';
//     });
// });
Route::get('/', fn() => view('dashboard'))->name('admin.index-light');
