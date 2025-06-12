<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'donatur')
            ->withCount('donations')
            ->withSum('donations', 'nominal')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $donations = $user->donations()->with('campaign')->latest()->paginate(10);
        $topups = $user->topups()->latest()->paginate(10);

        return view('admin.users.show', compact('user', 'donations', 'topups'));
    }

    public function updateBalance(Request $request, User $user)
    {
        $request->validate([
            'balance' => 'required|numeric|min:0'
        ]);

        $user->update(['balance' => $request->balance]);

        return redirect()->back()
            ->with('success', 'Saldo user berhasil diperbarui');
    }
}
