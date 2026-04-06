<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\WablasController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('home')
        : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');

    Route::middleware('redirect.admin')->group(function () {
        Route::get('/home', function () {
            return view('home');
        })->name('home');
        Route::get('/wablas/test', [WablasController::class, 'test'])->name('wablas.test');
        Route::post('/wablas/test', [WablasController::class, 'test'])->name('wablas.test');
        Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
        Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
        Route::resource('documents', DocumentController::class);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
