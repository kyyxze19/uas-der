@extends('master')

@section('judul', 'Detail Proyek')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Detail Proyek</h3>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $proyek->nama_proyek }}</h5>
            <p class="card-text"><strong>Klien:</strong> {{ $proyek->klien ?? '-' }}</p>
            <p class="card-text"><strong>Lokasi Proyek:</strong> {{ $proyek->lokasi_proyek }}</p>
            <p class="card-text"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }}</p>
            <p class="card-text"><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') }}</p>
            <p class="card-text"><strong>Status Proyek:</strong>
             @if($proyek->status_proyek == 'Belum Mulai')
             <span class="badge bg-danger">Belum Mulai</span> {{-- Merah --}}
            @elseif($proyek->status_proyek == 'Berjalan')
                <span class="badge bg-warning text-dark">Berjalan</span> {{-- Kuning --}}
            @else
                <span class="badge bg-success">Selesai</span> {{-- Hijau --}}
            @endif
            </p>
        </div>
    </div>

    <div class="mt-4 text-end">
        <a href="{{ route('kelola.proyek') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Kembali
        </a>
    </div>
</div>
@endsection
