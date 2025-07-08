@extends('master_karyawan')

@section('judul', 'Edit Data Pribadi')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Edit Data Pribadi</h3>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('karyawan.update_pribadi') }}" method="POST" id="editForm">
        @csrf
        @method('PUT')
        
        <!-- Debug info -->
        <div class="alert alert-info" style="font-size: 12px;">
            <strong>Debug Info:</strong><br>
            Form Action: {{ route('karyawan.update_pribadi') }}<br>
            Method: PUT<br>
            Current User: {{ Auth::user()->name ?? 'Not logged in' }}
        </div>

        {{-- Nama Lengkap (Disabled) --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ old('name', $karyawan->name) }}" disabled>
            <small class="form-text text-muted">Nama tidak dapat diubah. Hubungi admin untuk perubahan.</small>
        </div>

        {{-- NIK (Disabled) --}}
        <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input type="text" class="form-control" value="{{ old('nik', $karyawan->nik) }}" disabled>
            <small class="form-text text-muted">NIK tidak dapat diubah. Hubungi admin untuk perubahan.</small>
        </div>

        {{-- Email (Disabled) --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" value="{{ old('email', $karyawan->email) }}" disabled>
            <small class="form-text text-muted">Email tidak dapat diubah. Hubungi admin untuk perubahan.</small>
        </div>

        {{-- Tanggal Lahir (Editable) --}}
        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                   name="tanggal_lahir" 
                   value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}"
                   placeholder="Pilih tanggal lahir">
            @error('tanggal_lahir')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Tanggal lahir harus sebelum hari ini.</small>
        </div>
        
        {{-- Nomor Telepon (Editable) --}}
        <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor Telepon</label>
            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                   name="no_hp" 
                   value="{{ old('no_hp', $karyawan->no_hp) }}"
                   placeholder="Contoh: 08123456789"
                   maxlength="15">
            @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Masukkan nomor telepon yang valid (10-15 digit).</small>
        </div>

        {{-- Alamat (Editable) --}}
        <div class="mb-4">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                      name="alamat" 
                      rows="3"
                      placeholder="Masukkan alamat lengkap"
                      maxlength="500">{{ old('alamat', $karyawan->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Maksimal 500 karakter.</small>
        </div>

        {{-- Tombol Aksi --}}
        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4 py-2" id="submitBtn">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('karyawan.dashboard') }}" class="btn btn-secondary px-4 py-2 ms-2">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const noHpInput = document.querySelector('input[name="no_hp"]');
    
    // Auto-format nomor HP
    if (noHpInput) {
        noHpInput.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9+]/g, '');
            this.value = value;
        });
    }
});
</script>
@endsection