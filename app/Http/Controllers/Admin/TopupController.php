<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index()
    {
        $topups = Topup::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.topups.index', compact('topups'));
    }

    public function verify(Topup $topup)
    {
        if ($topup->status !== 'menunggu_verifikasi') {
            return redirect()->back()
                ->with('error', 'Top-up sudah diproses');
        }

        try {
            DB::transaction(function () use ($topup) {
                // Update status topup
                $topup->update(['status' => 'diverifikasi']);

                // Tambah saldo user
                $user = $topup->user;
                $user->balance += $topup->nominal;
                $user->save();

                // Buat notifikasi
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Top-Up Berhasil',
                    'message' => 'Top-Up sebesar Rp ' . number_format($topup->nominal, 0, ',', '.') . ' berhasil diverifikasi',
                    'status' => 'unread'
                ]);
            });

            return redirect()->back()
                ->with('success', 'Top-up berhasil diverifikasi');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi top-up');
        }
    }

    public function reject(Topup $topup)
    {
        if ($topup->status !== 'menunggu_verifikasi') {
            return redirect()->back()
                ->with('error', 'Top-up sudah diproses');
        }

        $topup->update(['status' => 'ditolak']);

        // Buat notifikasi
        Notification::create([
            'user_id' => $topup->user_id,
            'title' => 'Top-Up Ditolak',
            'message' => 'Top-Up sebesar Rp ' . number_format($topup->nominal, 0, ',', '.') . ' ditolak admin',
            'status' => 'unread'
        ]);

        return redirect()->back()
            ->with('success', 'Top-up berhasil ditolak');
    }
}
