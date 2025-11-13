<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Api\SignLanguageController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/study', [MainController::class, 'study'])->name('study');
Route::get('/dictionary', [MainController::class, 'dictionary'])->name('dictionary');
Route::get('/translator', [MainController::class, 'translator'])->name('translator');
Route::get('/profile', [MainController::class, 'profile'])->name('profile');

// API route
Route::post('/translate-sign-language', [SignLanguageController::class, 'translateSignLanguage'])
    ->name('api.translate');