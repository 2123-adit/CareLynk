{{-- resources/views/admin/campaigns/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Kampanye')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-eye"></i> Detail Kampanye</h1>
    <div class="btn-toolbar">
        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Campaign Info -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kampanye</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if($campaign->gambar)
                            <img src="{{ Storage::url($campaign->gambar) }}" 
                                 alt="Campaign Image" 
                                 class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-3" 
                                 style="height: 200px;">
                                <i class="bi bi-image display-4 text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h3>{{ $campaign->judul }}</h3>
                        <p class="text-muted">{{ $campaign->deskripsi }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-info">{{ $campaign->kategori }}</span>
                            @if($campaign->status === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </div>

                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary">{{ $campaign->formatted_target }}</h4>
                                <small class="text-muted">Target</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">{{ $campaign->formatted_total }}</h4>
                                <small class="text-muted">Terkumpul</small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" 
                                     role="progressbar" 
                                     style="width: {{ $campaign->progress_percent }}%"
                                     aria-valuenow="{{ $campaign->progress_percent }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($campaign->progress_percent, 1) }}%
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> 
                                Berakhir: {{ $campaign->tanggal_berakhir->format('d M Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Laporan -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Laporan Transparansi</h5>
            </div>
            <div class="card-body">
                @if($campaign->laporan_html)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Laporan sudah diupload
                        <a href="/api/laporan/{{ $campaign->id }}" target="_blank" class="btn btn-sm btn-outline-success ms-2">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                    </div>
                @endif

                <form action="{{ route('admin.campaigns.upload-laporan', $campaign) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="laporan_html" class="form-label">HTML Laporan</label>
                        <textarea class="form-control" 
                                  id="laporan_html" 
                                  name="laporan_html" 
                                  rows="8" 
                                  placeholder="Masukkan HTML laporan transparansi...">{{ old('laporan_html', $campaign->laporan_html) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload"></i> Upload Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ ENHANCED: Statistik Donasi -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i> Statistik Donasi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-primary">{{ $donations->total() }}</h4>
                            <small class="text-muted">Total Donatur</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <h4 class="text-success">{{ $campaign->formatted_total }}</h4>
                            <small class="text-muted">Dana Terkumpul</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php
                                $avgDonation = $donations->count() > 0 
                                    ? $campaign->total_terkumpul / $donations->count() 
                                    : 0;
                            @endphp
                            <h4 class="text-info">Rp {{ number_format($avgDonation, 0, ',', '.') }}</h4>
                            <small class="text-muted">Rata-rata Donasi</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            @php
                                $anonymousCount = $donations->where('is_anonymous', true)->count();
                            @endphp
                            <h4 class="text-warning">{{ $anonymousCount }}</h4>
                            <small class="text-muted">Donasi Anonim</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- ✅ ENHANCED: Donasi Terbaru dengan Pesan -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-heart-fill text-danger"></i> Donasi Terbaru
                </h5>
                <span class="badge bg-primary">{{ $donations->total() }} Donatur</span>
            </div>
            <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                @forelse($donations as $donation)
                    <div class="donation-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <!-- ✅ Nama Donatur dengan icon -->
                                <div class="d-flex align-items-center mb-1">
                                    @if($donation->is_anonymous)
                                        <i class="bi bi-eye-slash text-warning me-2"></i>
                                        <strong class="text-warning">{{ $donation->display_name }}</strong>
                                    @else
                                        <i class="bi bi-person-fill text-primary me-2"></i>
                                        <strong class="text-primary">{{ $donation->display_name }}</strong>
                                    @endif
                                </div>
                                
                                <!-- ✅ Tanggal dan Waktu -->
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-clock"></i> 
                                    {{ $donation->created_at->format('d M Y H:i') }}
                                    <span class="text-success ms-2">
                                        ({{ $donation->created_at->diffForHumans() }})
                                    </span>
                                </small>
                                
                                <!-- ✅ PESAN DONATUR -->
                                @if($donation->message)
                                    <div class="alert alert-light py-2 px-3 mb-2" 
                                         style="background-color: #f8f9fa; border-left: 3px solid #007bff;">
                                        <small class="text-info fw-bold">
                                            <i class="bi bi-chat-quote"></i> Pesan:
                                        </small>
                                        <div class="text-dark mt-1" style="font-style: italic;">
                                            "{{ $donation->message }}"
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- ✅ Nominal Donasi -->
                            <div class="text-end ms-3">
                                <strong class="text-success fs-6">
                                    {{ $donation->formatted_nominal }}
                                </strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada donasi</p>
                    </div>
                @endforelse

                <!-- ✅ Pagination untuk donasi -->
                @if($donations->hasPages())
                    <div class="text-center mt-3">
                        {{ $donations->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- ✅ BONUS: Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning-fill"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.campaigns.edit', $campaign) }}" 
                       class="btn btn-outline-warning">
                        <i class="bi bi-pencil"></i> Edit Kampanye
                    </a>
                    
                    @if($campaign->status === 'aktif')
                        <form action="{{ route('admin.campaigns.update', $campaign) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="selesai">
                            <input type="hidden" name="judul" value="{{ $campaign->judul }}">
                            <input type="hidden" name="deskripsi" value="{{ $campaign->deskripsi }}">
                            <input type="hidden" name="kategori" value="{{ $campaign->kategori }}">
                            <input type="hidden" name="target_donasi" value="{{ $campaign->target_donasi }}">
                            <input type="hidden" name="tanggal_berakhir" value="{{ $campaign->tanggal_berakhir->format('Y-m-d\TH:i') }}">
                            
                            <button type="submit" 
                                    class="btn btn-outline-secondary w-100"
                                    onclick="return confirm('Yakin ingin menyelesaikan kampanye ini?')">
                                <i class="bi bi-check-circle"></i> Selesaikan Kampanye
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('admin.donations.index') }}?campaign={{ $campaign->id }}" 
                       class="btn btn-outline-info">
                        <i class="bi bi-list-ul"></i> Lihat Semua Donasi
                    </a>
                    
                    <button class="btn btn-outline-success" 
                            onclick="exportDonations({{ $campaign->id }})">
                        <i class="bi bi-download"></i> Export Data Donasi
                    </button>
                </div>
            </div>
        </div>

        <!-- ✅ BONUS: Campaign Analytics -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> Analytics
                </h5>
            </div>
            <div class="card-body">
                @php
                    $today = $donations->where('created_at', '>=', now()->startOfDay())->count();
                    $thisWeek = $donations->where('created_at', '>=', now()->startOfWeek())->count();
                    $thisMonth = $donations->where('created_at', '>=', now()->startOfMonth())->count();
                @endphp
                
                <div class="row text-center">
                    <div class="col-4">
                        <h6 class="text-primary">{{ $today }}</h6>
                        <small class="text-muted">Hari Ini</small>
                    </div>
                    <div class="col-4">
                        <h6 class="text-success">{{ $thisWeek }}</h6>
                        <small class="text-muted">Minggu Ini</small>
                    </div>
                    <div class="col-4">
                        <h6 class="text-warning">{{ $thisMonth }}</h6>
                        <small class="text-muted">Bulan Ini</small>
                    </div>
                </div>
                
                <!-- Progress Bar Analytics -->
                <div class="mt-3">
                    <small class="text-muted">Progress Target:</small>
                    <div class="progress mt-1" style="height: 8px;">
                        <div class="progress-bar" 
                             style="width: {{ $campaign->progress_percent }}%"
                             role="progressbar">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small class="text-muted">{{ number_format($campaign->progress_percent, 1) }}%</small>
                        @php
                            $remaining = $campaign->target_donasi - $campaign->total_terkumpul;
                        @endphp
                        <small class="text-muted">
                            Sisa: Rp {{ number_format($remaining, 0, ',', '.') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ BONUS: Custom CSS untuk styling yang lebih baik -->
<style>
.donation-item {
    transition: all 0.3s ease;
}

.donation-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    margin: -10px;
}

.alert-light {
    border: 1px solid #e3f2fd;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    border: none;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-bottom: none;
}

.progress-bar {
    background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
}
</style>

<!-- ✅ BONUS: JavaScript untuk export data -->
<script>
function exportDonations(campaignId) {
    // Simple CSV export
    window.location.href = `/admin/campaigns/${campaignId}/export-donations`;
}
</script>
@endsection