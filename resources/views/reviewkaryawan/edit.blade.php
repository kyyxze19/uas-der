@extends('master')

@section('judul', 'Edit Karyawan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Data Karyawan</h3>

    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Lengkap --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name', $karyawan->name) }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- NIK --}}
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik"
                value="{{ old('nik', $karyawan->nik) }}" required>
            @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jenis Kelamin --}}
        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email', $karyawan->email) }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password (Opsional) --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (Opsional)</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
            <div class="form-text">Kosongkan jika tidak ingin mengganti password.</div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status Keaktifan --}}
        <div class="mb-4">
            <label for="status_keaktifan" class="form-label">Status Keaktifan</label>
            <select name="status_keaktifan" class="form-select @error('status_keaktifan') is-invalid @enderror" required>
                <option value="">-- Pilih --</option>
                <option value="Aktif" {{ old('status_keaktifan', $karyawan->status_keaktifan) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status_keaktifan', $karyawan->status_keaktifan) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status_keaktifan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4 py-2">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="/review-karyawan" class="btn btn-secondary px-4 py-2 ms-2">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
