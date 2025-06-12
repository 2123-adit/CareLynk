<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['user', 'campaign'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.donations.index', compact('donations'));
    }
}