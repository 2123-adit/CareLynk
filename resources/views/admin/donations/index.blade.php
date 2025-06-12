@extends('layouts.admin')

@section('title', 'Kelola Donasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-gift"></i> Kelola Donasi</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Donatur</th>
                        <th>Kampanye</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                    <tr>
                        <td>
                            <strong>{{ $donation->user->name }}</strong><br>
                            <small class="text-muted">{{ $donation->user->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $donation->campaign->judul }}</strong><br>
                            <small class="text-muted">
                                <span class="badge bg-info">{{ $donation->campaign->kategori }}</span>
                            </small>
                        </td>
                        <td>
                            <strong class="text-success">{{ $donation->formatted_nominal }}</strong>
                        </td>
                        <td>
                            <small>{{ $donation->created_at->format('d M Y H:i') }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada donasi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($donations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection