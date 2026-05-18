<?php

use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\AnalisisController;
use App\Http\Controllers\User\UserChatController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('home');

    Route::get('/login', function () {
        return view('auth.login');
    });

    Route::post('/login', LoginController::class)->name('login');
});

// User Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', LogoutController::class)->name('logout');

    // User Dashboard
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // User Chat Routes
    Route::prefix('user/chat')->name('user.chat.')->group(function () {
        Route::get('/', [UserChatController::class, 'index'])->name('index');
        Route::get('/create', [UserChatController::class, 'createConversation'])->name('create');
        Route::post('/send', [UserChatController::class, 'sendMessage'])->name('send');
        Route::delete('/{conversation}', [UserChatController::class, 'deleteConversation'])->name('delete');
    });

    // User Analisis Routes
    Route::prefix('user/analisis')->name('user.analisis.')->group(function () {
        Route::get('/', [AnalisisController::class, 'index'])->name('index');
        Route::get('/create', [AnalisisController::class, 'create'])->name('create');
        Route::post('/', [AnalisisController::class, 'store'])->name('store');
        Route::get('/{analisi}', [AnalisisController::class, 'show'])->name('show');
        Route::get('/{analisi}/edit', [AnalisisController::class, 'edit'])->name('edit');
        Route::put('/{analisi}', [AnalisisController::class, 'update'])->name('update');
        Route::delete('/{analisi}', [AnalisisController::class, 'destroy'])->name('destroy');
        Route::post('/{analisi}/analisis', [AnalisisController::class, 'performAnalisis'])->name('analisis');
        
        // File-specific routes
        Route::post('/{analisi}/file', [AnalisisController::class, 'storeFile'])->name('file.store');
        Route::post('/file/{file}/ocr', [AnalisisController::class, 'performOcr'])->name('ocr.file');
        Route::delete('/file/{file}', [AnalisisController::class, 'destroyFile'])->name('file.destroy');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/create', [ChatController::class, 'createConversation'])->name('chat.create');
        Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
        Route::delete('/chat/{conversation}', [ChatController::class, 'deleteConversation'])->name('chat.delete');

        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('profile');
    });
});
