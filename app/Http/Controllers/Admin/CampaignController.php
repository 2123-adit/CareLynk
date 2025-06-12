<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Pendidikan,Kesehatan,Bencana,Sosial',
            'target_donasi' => 'required|numeric|min:1',
            'tanggal_berakhir' => 'required|date|after:today',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('campaigns', 'public');
        }

        Campaign::create($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Kampanye berhasil dibuat');
    }

    public function show(Campaign $campaign)
    {
        $donations = $campaign->donations()->with('user')->latest()->paginate(10);
        return view('admin.campaigns.show', compact('campaign', 'donations'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Pendidikan,Kesehatan,Bencana,Sosial',
            'target_donasi' => 'required|numeric|min:1',
            'tanggal_berakhir' => 'required|date',
            'status' => 'required|in:aktif,selesai',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($campaign->gambar) {
                Storage::disk('public')->delete($campaign->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Kampanye berhasil diperbarui');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->gambar) {
            Storage::disk('public')->delete($campaign->gambar);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Kampanye berhasil dihapus');
    }

    public function uploadLaporan(Request $request, Campaign $campaign)
    {
        $request->validate([
            'laporan_html' => 'required|string'
        ]);

        $campaign->update([
            'laporan_html' => $request->laporan_html
        ]);

        return redirect()->back()
            ->with('success', 'Laporan berhasil diupload');
    }
}
