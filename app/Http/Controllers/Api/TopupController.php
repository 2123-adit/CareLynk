<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topup;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000'
        ]);

        $topup = Topup::create([
            'user_id' => $request->user()->id,
            'nominal' => $request->nominal,
            'status' => 'menunggu_verifikasi'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan top-up berhasil, menunggu verifikasi admin',
            'data' => $topup
        ]);
    }

    public function history(Request $request)
    {
        $topups = Topup::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $topups
        ]);
    }
}
