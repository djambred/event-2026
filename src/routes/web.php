<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Route::get('/', function () {
//     return view('welcome');
// });

// Frontend Routes (landing page)
Route::get('/', [EventController::class, 'home'])->name('home');
Route::get('/rules', [EventController::class, 'rules'])->name('rules');
Route::get('/announcements', [EventController::class, 'announcements'])->name('announcements');

Route::prefix('registration')->name('registration.')->group(function () {
    Route::get('/national', [RegistrationController::class, 'national'])->name('national');
    Route::post('/national', [RegistrationController::class, 'storeNational'])->name('national.store');
    Route::get('/international', [RegistrationController::class, 'international'])->name('international');
    Route::post('/international', [RegistrationController::class, 'storeInternational'])->name('international.store');
});

// Participant Portal
Route::prefix('participant')->name('participant.')->group(function () {
    Route::get('/login', [ParticipantController::class, 'loginForm'])->name('login');
    Route::post('/login', [ParticipantController::class, 'login'])->name('login.post');
    Route::get('/change-password', [ParticipantController::class, 'changePasswordForm'])->name('password.change');
    Route::post('/change-password', [ParticipantController::class, 'updatePassword'])->name('password.update');
    Route::get('/portal', [ParticipantController::class, 'portal'])->name('portal');
    Route::post('/youtube', [ParticipantController::class, 'updateYoutube'])->name('youtube.update');
    Route::get('/certificate', [ParticipantController::class, 'downloadCertificate'])->name('certificate');
    Route::post('/logout', [ParticipantController::class, 'logout'])->name('logout');
});
