<?php
// routes/web.php - Updated

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// ✅ ADMIN AUTH ROUTES (tanpa middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ✅ ADMIN PROTECTED ROUTES (dengan middleware)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Campaigns
    Route::resource('campaigns', CampaignController::class);
    Route::post('campaigns/{campaign}/upload-laporan', [CampaignController::class, 'uploadLaporan'])
        ->name('campaigns.upload-laporan');
    
    // Top-ups
    Route::get('topups', [TopupController::class, 'index'])->name('topups.index');
    Route::patch('topups/{topup}/verify', [TopupController::class, 'verify'])->name('topups.verify');
    Route::patch('topups/{topup}/reject', [TopupController::class, 'reject'])->name('topups.reject');
    
    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('users/{user}/balance', [UserController::class, 'updateBalance'])->name('users.update-balance');
    
    // Donations
    Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
});