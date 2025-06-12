@extends('layouts.admin')

@section('title', 'Kelola Kampanye')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-megaphone"></i> Kelola Kampanye</h1>
    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kampanye
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Target</th>
                        <th>Terkumpul</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        <td>
                            @if($campaign->gambar)
                                <img src="{{ Storage::url($campaign->gambar) }}" 
                                     alt="Campaign Image" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px; border-radius: 5px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $campaign->judul }}</strong><br>
                            <small class="text-muted">{{ Str::limit($campaign->deskripsi, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $campaign->kategori }}</span>
                        </td>
                        <td>{{ $campaign->formatted_target }}</td>
                        <td>{{ $campaign->formatted_total }}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" 
                                     role="progressbar" 
                                     style="width: {{ $campaign->progress_percent }}%"
                                     aria-valuenow="{{ $campaign->progress_percent }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($campaign->progress_percent, 1) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($campaign->status === 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.campaigns.show', $campaign) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.campaigns.edit', $campaign) }}" 
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada kampanye</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($campaigns->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</div>
@endsection