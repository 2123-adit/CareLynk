<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'nominal' => 'required|numeric|min:1000',
            'is_anonymous' => 'boolean',                    // ✅ TAMBAH
            'donor_name' => 'nullable|string|max:255',     // ✅ TAMBAH
            'message' => 'nullable|string|max:500'         // ✅ TAMBAH
        ]);

        $user = $request->user();
        $campaign = Campaign::findOrFail($request->campaign_id);

        if ($user->balance < $request->nominal) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo tidak mencukupi'
            ], 400);
        }

        if ($campaign->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Kampanye tidak aktif'
            ], 400);
        }

        try {
            DB::transaction(function () use ($user, $campaign, $request) {
                // Lock user untuk menghindari race condition
                $user = $user->lockForUpdate()->find($user->id);

                // Potong saldo user
                $user->balance -= $request->nominal;
                $user->save();

                // Tambah total terkumpul kampanye
                $campaign->total_terkumpul += $request->nominal;
                $campaign->save();

                // ✅ Record donasi dengan tambahan data
                $donation = Donation::create([
                    'user_id' => $user->id,
                    'campaign_id' => $campaign->id,
                    'nominal' => $request->nominal,
                    'is_anonymous' => $request->is_anonymous ?? false,
                    'donor_name' => $request->donor_name,
                    'message' => $request->message,
                ]);

                // ✅ Buat notifikasi dengan donor name yang sesuai
                $donorName = $request->is_anonymous
                    ? 'Anonim'
                    : ($request->donor_name ?: $user->name);

                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Donasi Berhasil',
                    'message' => "Donasi sebesar Rp " . number_format($request->nominal, 0, ',', '.') .
                               " dari $donorName berhasil untuk kampanye " . $campaign->judul,
                    'status' => 'unread'
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Donasi berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses donasi'
            ], 500);
        }
    }

    public function history(Request $request)
    {
        $donations = Donation::with('campaign')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $donations
        ]);
    }
}
