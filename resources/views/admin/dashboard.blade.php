@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Donasi</div>
                        <div class="h5 mb-0 font-weight-bold">
                            Rp {{ number_format($stats['total_donasi'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-cash-stack fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-2 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Kampanye Aktif</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_kampanye'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-megaphone fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-3 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['total_user'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card-4 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Top-Up Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold">{{ $stats['topup_menunggu'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Buat Kampanye Baru
                    </a>
                    <a href="{{ route('admin.topups.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-credit-card"></i> Kelola Top-Up
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-people"></i> Kelola Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> System Info
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        System berjalan normal
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        Database terhubung
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-check-circle text-success"></i> 
                        API endpoint aktif
                    </li>
                    @if($stats['topup_menunggu'] > 0)
                    <li class="mb-2">
                        <i class="bi bi-exclamation-triangle text-warning"></i> 
                        {{ $stats['topup_menunggu'] }} top-up menunggu verifikasi
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection