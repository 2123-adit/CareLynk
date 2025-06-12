@extends('layouts.admin')

@section('title', 'Kelola Top-Up')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-credit-card"></i> Kelola Top-Up</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topups as $topup)
                    <tr>
                        <td>
                            <strong>{{ $topup->user->name }}</strong><br>
                            <small class="text-muted">{{ $topup->user->email }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">{{ $topup->formatted_nominal }}</strong>
                        </td>
                        <td>
                            {!! $topup->status_badge !!}
                        </td>
                        <td>
                            <small>{{ $topup->created_at->format('d M Y H:i') }}</small>
                        </td>
                        <td>
                            @if($topup->status === 'menunggu_verifikasi')
                                <div class="btn-group" role="group">
                                    <form action="{{ route('admin.topups.verify', $topup) }}" 
                                          method="POST" 
                                          style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-sm btn-success"
                                                onclick="return confirm('Verifikasi top-up ini?')">
                                            <i class="bi bi-check-circle"></i> Verifikasi
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.topups.reject', $topup) }}" 
                                          method="POST" 
                                          style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Tolak top-up ini?')">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada top-up</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($topups->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $topups->links() }}
            </div>
        @endif
    </div>
</div>
@endsection