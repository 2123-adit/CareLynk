<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::where('status', 'aktif');

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $campaigns = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $campaigns
        ]);
    }

    public function show($id)
    {
        $campaign = Campaign::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $campaign
        ]);
    }

    public function laporan($id)
    {
        $campaign = Campaign::findOrFail($id);
        
        if (!$campaign->laporan_html) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak tersedia'
            ], 404);
        }

        return response($campaign->laporan_html)->header('Content-Type', 'text/html');
    }
}