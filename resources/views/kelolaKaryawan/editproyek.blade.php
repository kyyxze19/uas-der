@extends('master')

@section('judul', 'Edit Proyek')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Data Proyek</h3>

    <form action="{{ route('proyek.update', $proyek->id_proyek) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Proyek --}}
        <div class="mb-3">
            <label for="nama_proyek" class="form-label">Nama Proyek</label>
            <input type="text" name="nama_proyek" class="form-control @error('nama_proyek') is-invalid @enderror"
                   value="{{ old('nama_proyek', $proyek->nama_proyek) }}" required>
            @error('nama_proyek')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Lokasi Proyek --}}
        <div class="mb-3">
            <label for="lokasi_proyek" class="form-label">Lokasi Proyek</label>
            <input type="text" name="lokasi_proyek" class="form-control @error('lokasi_proyek') is-invalid @enderror"
                   value="{{ old('lokasi_proyek', $proyek->lokasi_proyek) }}" required>
            @error('lokasi_proyek')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Klien --}}
        <div class="mb-3">
            <label for="klien" class="form-label">Klien</label>
            <input type="text" name="klien" class="form-control @error('klien') is-invalid @enderror"
                   value="{{ old('klien', $proyek->klien) }}">
            @error('klien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai', $proyek->tanggal_mulai) }}" required>
            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Selesai --}}
        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                   value="{{ old('tanggal_selesai', $proyek->tanggal_selesai) }}" required>
            @error('tanggal_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Proyek --}}
        <div class="mb-3">
            <label for="status_proyek" class="form-label">Status Proyek</label>
            <select name="status_proyek" class="form-select @error('status_proyek') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="Belum Mulai" {{ old('status_proyek', $proyek->status_proyek) == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                <option value="Berjalan" {{ old('status_proyek', $proyek->status_proyek) == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                <option value="Selesai" {{ old('status_proyek', $proyek->status_proyek) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status_proyek')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="text-center">
            <button type="submit" class="btn btn-success px-4 py-2">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('kelola.proyek') }}" class="btn btn-secondary px-4 py-2 ms-2">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
