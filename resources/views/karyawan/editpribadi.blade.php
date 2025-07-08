@extends('master_karyawan')

@section('judul', 'Edit Data Pribadi')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Data Pribadi</h3>

    <form action="{{ route('karyawan.update_pribadi') }}" method="POST">
        @csrf
        @method('PUT')

      {{-- Nama Lengkap (Disabled) --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ old('name', $karyawan->name) }}" disabled>
        </div>

        {{-- NIK (Disabled) --}}
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" value="{{ old('nik', $karyawan->nik) }}" disabled>
        </div>

        {{-- Email (Disabled) --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ old('email', $karyawan->email) }}" disabled>
        </div>

        {{-- Tanggal Lahir (Editable) --}}
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}">
            @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        {{-- Nomor Telepon (Editable) --}}
        <div class="mb-3">
            <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon', $karyawan->nomor_telepon) }}">
            @error('nomor_telepon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alamat (Editable) --}}
        <div class="mb-4">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="3">{{ old('alamat', $karyawan->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary px-4 py-2 ms-2">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection