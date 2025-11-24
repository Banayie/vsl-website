<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Api\SignLanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\AdminController;

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');


// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Topics CRUD
    Route::get('/topics', [AdminController::class, 'topics'])->name('admin.topics');
    Route::get('/topics/create', [AdminController::class, 'topicCreate'])->name('admin.topics.create');
    Route::post('/topics/store', [AdminController::class, 'topicStore'])->name('admin.topics.store');
    Route::get('/topics/{id}/edit', [AdminController::class, 'topicEdit'])->name('admin.topics.edit');
    Route::post('/topics/{id}/update', [AdminController::class, 'topicUpdate'])->name('admin.topics.update');
    Route::delete('/topics/{id}/delete', [AdminController::class, 'topicDelete'])->name('admin.topics.delete');

    // Lesson CRUD
    Route::get('/lessons', [AdminController::class, 'lessons'])->name('admin.lessons');
    Route::get('/lessons/create', [AdminController::class, 'createLesson'])->name('admin.lessons.create');
    Route::post('/lessons/store', [AdminController::class, 'storeLesson'])->name('admin.lessons.store');
    Route::get('/lessons/edit/{id}', [AdminController::class, 'editLesson'])->name('admin.lessons.edit');
    Route::post('/lessons/update/{id}', [AdminController::class, 'updateLesson'])->name('admin.lessons.update');
    Route::delete('/lessons/delete/{id}', [AdminController::class, 'deleteLesson'])->name('admin.lessons.delete');

    // User CRUD
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

// Home
Route::get('/', [MainController::class, 'index'])->name('home');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// --- PROTECTED ROUTES ---
Route::middleware('auth')->group(function () {

    Route::get('/study', [StudyController::class, 'topics'])->name('study');


    Route::get('/study/topic/{topic}', [StudyController::class, 'topicDetail'])
        ->name('study.topic');

    Route::get('/study/lesson/{lesson}', [StudyController::class, 'lessonDetail'])
        ->name('study.lesson');

    Route::post(
        '/study/lesson/{lesson}/complete',
        [StudyController::class, 'completeLesson']
    )->name('study.lesson.complete');


    Route::get('/dictionary', [MainController::class, 'dictionary'])->name('dictionary');
    Route::get('/translator', [MainController::class, 'translator'])->name('translator');


    // Profile
    Route::get('/profile', [MainController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update-info', [AuthController::class, 'updateInfo'])->name('profile.updateInfo');
    Route::post('/profile/update-avatar', [AuthController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::post('/profile/update-password', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');



    // API route (có muốn bảo vệ hay không tùy bạn)
    Route::post(
        '/translate-sign-language',
        [SignLanguageController::class, 'translateSignLanguage']
    )->name('api.translate');

});
