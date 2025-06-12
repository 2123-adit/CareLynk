<?php
// routes/api.php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TopupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Campaigns (public access)
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/{id}', [CampaignController::class, 'show']);
Route::get('/laporan/{id}', [CampaignController::class, 'laporan']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Donations
    Route::post('/donasi', [DonationController::class, 'store']);
    Route::get('/donasi/history', [DonationController::class, 'history']);
    
    // Top-up
    Route::post('/topup', [TopupController::class, 'store']);
    Route::get('/topup/history', [TopupController::class, 'history']);
    
    // Notifications
    Route::get('/notifikasi', [NotificationController::class, 'index']);
    Route::post('/notifikasi/read', [NotificationController::class, 'markAsRead']);
});