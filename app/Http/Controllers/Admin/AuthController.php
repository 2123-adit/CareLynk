<?php
// app/Http/Controllers/Admin/AuthController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        
        // Cek apakah user ada dan role-nya admin
        $user = User::where('email', $request->email)->first();
        
        if (!$user || $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar sebagai admin.',
            ])->withInput();
        }

        // Attempt login dengan guard admin
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Berhasil logout');
    }
}