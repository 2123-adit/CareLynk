<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Topup;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donasi' => Donation::sum('nominal'),
            'total_kampanye' => Campaign::where('status', 'aktif')->count(),
            'total_user' => User::where('role', 'donatur')->count(),
            'topup_menunggu' => Topup::where('status', 'menunggu_verifikasi')->count()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}