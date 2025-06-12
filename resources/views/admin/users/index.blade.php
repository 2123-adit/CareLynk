@extends('layouts.admin')

@section('title', 'Kelola Users')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-people"></i> Kelola Users</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Saldo</th>
                        <th>Total Donasi</th>
                        <th>Jumlah Donasi</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <strong class="text-success">
                                Rp {{ number_format($user->balance, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            <strong class="text-primary">
                                Rp {{ number_format($user->donations_sum_nominal ?? 0, 0, ',', '.') }}
                            </strong>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $user->donations_count }} kali</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection