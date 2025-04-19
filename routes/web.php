<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', 'logout')->name('logout');
    });
});

Route::controller(EventRegistrationController::class)->middleware('auth')->prefix('events/{event}')->name('events.')->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('unregister', 'unregister')->name('unregister');
});

Route::controller(EventController::class)->name('events.')->group(function () {
    Route::middleware(['auth', 'can:manage-events'])->prefix('events')->group(function () {
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{event}/edit', 'edit')->name('edit');
        Route::post('{event}', 'update')->name('update');
        Route::delete('{event}', 'destroy')->name('destroy');
        Route::get('manage', 'manage')->name('manage');
    });

    Route::get('/', 'index')->name('index');
    Route::get('event/{event}', 'show')->name('show');
});

Route::controller(NotificationController::class)->middleware(['auth'])->prefix('notifications')->group(function () {
    Route::get('/', 'index');
    Route::patch('{id}/mark-as-read', 'markAsRead');
    Route::patch('mark-all-as-read', 'markAllAsRead');
});