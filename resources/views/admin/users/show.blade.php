@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-person-circle"></i> Detail User</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- User Info -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi User</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle display-1 text-muted"></i>
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="row text-center mt-4">
                    <div class="col-12 mb-3">
                        <h3 class="text-success">
                            Rp {{ number_format($user->balance, 0, ',', '.') }}
                        </h3>
                        <small class="text-muted">Saldo Saat Ini</small>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-primary">{{ $donations->total() }}</h5>
                        <small class="text-muted">Total Donasi</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-warning">{{ $topups->total() }}</h5>
                        <small class="text-muted">Total Top-Up</small>
                    </div>
                </div>

                <div class="mt-4">
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> 
                        Bergabung {{ $user->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>
        </div>

        <!-- Edit Saldo -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Saldo</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update-balance', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="balance" class="form-label">Saldo Baru</label>
                        <input type="number" 
                               class="form-control" 
                               id="balance" 
                               name="balance" 
                               value="{{ $user->balance }}" 
                               min="0"
                               step="1000"
                               required>
                    </div>
                    
                    <button type="submit" 
                            class="btn btn-warning w-100"
                            onclick="return confirm('Apakah Anda yakin ingin mengubah saldo user ini?')">
                        <i class="bi bi-pencil"></i> Update Saldo
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Transactions -->
    <div class="col-lg-8">
        <!-- Donasi -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Donasi</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Kampanye</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $donation)
                            <tr>
                                <td>
                                    <strong>{{ $donation->campaign->judul }}</strong><br>
                                    <small class="text-muted">{{ $donation->campaign->kategori }}</small>
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
                                <td colspan="3" class="text-center py-3">
                                    <small class="text-muted">Belum ada donasi</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($donations->hasPages())
                    <div class="mt-3">
                        {{ $donations->appends(['topup_page' => request('topup_page')])->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Top-Up -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Top-Up</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topups as $topup)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $topup->formatted_nominal }}</strong>
                                </td>
                                <td>
                                    {!! $topup->status_badge !!}
                                </td>
                                <td>
                                    <small>{{ $topup->created_at->format('d M Y H:i') }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-3">
                                    <small class="text-muted">Belum ada top-up</small>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($topups->hasPages())
                    <div class="mt-3">
                        {{ $topups->appends(['donation_page' => request('donation_page')])->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection