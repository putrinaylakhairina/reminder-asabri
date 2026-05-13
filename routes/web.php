<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PensionerController as AdminPensionerController;
use App\Http\Controllers\Asabri\DashboardController as AsabriDashboardController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.pensioners.index');
    }
    return redirect()->route('asabri.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/pensioners/export-pdf', [AdminPensionerController::class, 'exportPdf'])->name('pensioners.export-pdf');
    Route::resource('pensioners', AdminPensionerController::class);

    // Reminder Routes
    Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    Route::get('/reminders/create', [ReminderController::class, 'create'])->name('reminders.create');
    Route::post('/reminders', [ReminderController::class, 'store'])->name('reminders.store');
    Route::post('/reminders/{reminder}/send', [ReminderController::class, 'send'])->name('reminders.send');
    Route::post('/reminders/generate', [ReminderController::class, 'generate'])->name('reminders.generate');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
    
    // History Routes
    Route::get('/history', [\App\Http\Controllers\Admin\HistoryController::class, 'index'])->name('history.index');
});

// Asabri (User) Routes
Route::middleware(['auth', 'role:asabri'])->prefix('asabri')->name('asabri.')->group(function () {
    Route::get('/dashboard', [AsabriDashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
