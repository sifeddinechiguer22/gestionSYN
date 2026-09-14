<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isResident()
            ? redirect()->route('resident.dashboard')
            : redirect()->route('syndic.dashboard');
    }
    return redirect()->route('login');
});

// Routes for Syndic Space
Route::prefix('syndic')->name('syndic.')->middleware(['auth', 'role:syndic'])->group(function () {
    Route::get('/dashboard', App\Http\Controllers\Syndic\DashboardController::class)->name('dashboard');
    Route::get('/dashboard/pdf', [App\Http\Controllers\Syndic\DashboardController::class, 'downloadReport'])->name('dashboard.pdf');
    Route::get('/residence', App\Http\Controllers\Syndic\ResidenceController::class)->name('residence');
    
    Route::get('/buildings', [App\Http\Controllers\Syndic\BuildingController::class, 'index'])->name('buildings');
    Route::post('/buildings', [App\Http\Controllers\Syndic\BuildingController::class, 'store'])->name('buildings.store');

    Route::get('/apartments', [App\Http\Controllers\Syndic\ApartmentController::class, 'index'])->name('apartments');
    Route::post('/apartments', [App\Http\Controllers\Syndic\ApartmentController::class, 'store'])->name('apartments.store');

    Route::get('/residents', [App\Http\Controllers\Syndic\ResidentController::class, 'index'])->name('residents');
    Route::post('/residents', [App\Http\Controllers\Syndic\ResidentController::class, 'store'])->name('residents.store');

    Route::get('/payments', [App\Http\Controllers\Syndic\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [App\Http\Controllers\Syndic\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/create', [App\Http\Controllers\Syndic\PaymentController::class, 'create'])->name('payments.create');
    Route::get('/payments/{payment}/receipt', [App\Http\Controllers\Syndic\PaymentController::class, 'downloadReceipt'])->name('payments.receipt');

    Route::get('/expenses', [App\Http\Controllers\Syndic\ExpenseController::class, 'index'])->name('expenses');
    Route::post('/expenses', [App\Http\Controllers\Syndic\ExpenseController::class, 'store'])->name('expenses.store');

    Route::get('/complaints', [App\Http\Controllers\Syndic\ComplaintController::class, 'index'])->name('complaints');

    Route::get('/complaints/{complaint}', [App\Http\Controllers\Syndic\ComplaintController::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/reply', [App\Http\Controllers\Syndic\ComplaintController::class, 'reply'])->name('complaints.reply');
    Route::get('/complaints/{complaint}/pdf', [App\Http\Controllers\Syndic\ComplaintController::class, 'downloadPdf'])->name('complaints.pdf');

    Route::get('/documents', [App\Http\Controllers\Syndic\DocumentController::class, 'index'])->name('documents');
    Route::post('/documents', [App\Http\Controllers\Syndic\DocumentController::class, 'store'])->name('documents.store');

    Route::get('/announcements', [App\Http\Controllers\Syndic\AnnouncementController::class, 'index'])->name('announcements');
    Route::post('/announcements', [App\Http\Controllers\Syndic\AnnouncementController::class, 'store'])->name('announcements.store');

    Route::get('/notifications', App\Http\Controllers\Syndic\NotificationController::class)->name('notifications');
});

// Routes for Resident Space
Route::prefix('resident')->name('resident.')->middleware(['auth', 'role:resident'])->group(function () {
    Route::get('/dashboard', App\Http\Controllers\Resident\DashboardController::class)->name('dashboard');
    Route::get('/apartment', App\Http\Controllers\Resident\ApartmentController::class)->name('apartment');
    Route::get('/payments', App\Http\Controllers\Resident\PaymentController::class)->name('payments');

    Route::get('/complaints', [App\Http\Controllers\Resident\ComplaintController::class, 'index'])->name('complaints');
    Route::post('/complaints', [App\Http\Controllers\Resident\ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}/pdf', [App\Http\Controllers\Resident\ComplaintController::class, 'downloadPdf'])->name('complaints.pdf');

    Route::get('/documents', App\Http\Controllers\Resident\DocumentController::class)->name('documents');
    Route::get('/announcements', App\Http\Controllers\Resident\AnnouncementController::class)->name('announcements');
    Route::get('/notifications', App\Http\Controllers\Resident\NotificationController::class)->name('notifications');
});

Route::get('/dashboard', function () {
    if (auth()->user()?->isResident()) {
        return redirect()->route('resident.dashboard');
    }
    return redirect()->route('syndic.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/payments/{payment}/receipt', [App\Http\Controllers\Syndic\PaymentController::class, 'downloadReceipt'])->name('payments.receipt');
    Route::get('/syndic/payments/{payment}/receipt', [App\Http\Controllers\Syndic\PaymentController::class, 'downloadReceipt'])->name('syndic.payments.receipt');
    Route::get('/resident/payments/{payment}/receipt', [App\Http\Controllers\Syndic\PaymentController::class, 'downloadReceipt'])->name('resident.payments.receipt');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
