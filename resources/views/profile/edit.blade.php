@extends('master')

@section('judul')
  Edit Profil
@endsection

@section('subjudul')
  Edit Data Pribadi
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Edit Profil</h5>
            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
              <i class="ti ti-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
              <div class="col-md-3 text-center mb-4">
                <div class="avatar-xl mx-auto mb-3">
                  <div class="avatar-title bg-primary text-white rounded-circle" style="width: 100px; height: 100px; line-height: 100px; font-size: 36px;">
                    {{ substr($user->name, 0, 1) }}
                  </div>
                </div>
                <h5 class="fw-semibold mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                <span class="badge bg-{{ $user->status_keaktifan == 'aktif' ? 'success' : 'danger' }} mt-2">
                  {{ ucfirst($user->status_keaktifan) }}
                </span>
              </div>
              
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">NIK</label>
                      <input type="text" class="form-control" value="{{ $user->nik }}" readonly>
                      <small class="form-text text-muted">NIK tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">Email</label>
                      <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                      <small class="form-text text-muted">Email tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">Jenis Kelamin</label>
                      <input type="text" class="form-control" value="{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
                      <small class="form-text text-muted">Jenis kelamin tidak dapat diubah</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">Tanggal Lahir</label>
                      <input type="text" class="form-control" value="{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y') : '-' }}" readonly>
                      <small class="form-text text-muted">Tanggal lahir tidak dapat diubah</small>
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                      <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                                rows="3" required placeholder="Masukkan alamat lengkap...">{{ old('alamat', $user->alamat) }}</textarea>
                      @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="form-text text-muted">Alamat yang dapat diedit</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label fw-semibold">No. HP <span class="text-danger">*</span></label>
                      <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                             value="{{ old('no_hp', $user->no_hp) }}" required 
                             placeholder="Contoh: 08123456789">
                      @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="form-text text-muted">Nomor HP yang dapat diedit</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">Status Keaktifan</label>
                      <input type="text" class="form-control" 
                             value="{{ ucfirst($user->status_keaktifan) }}" readonly>
                      <small class="form-text text-muted">Status keaktifan dikelola oleh admin</small>
                    </div>
                    
                    <div class="mb-3">
                      <label class="form-label text-muted fw-semibold">Tanggal Masuk</label>
                      <input type="text" class="form-control" 
                             value="{{ $user->tanggal_masuk ? \Carbon\Carbon::parse($user->tanggal_masuk)->format('d/m/Y') : '-' }}" readonly>
                      <small class="form-text text-muted">Tanggal masuk tidak dapat diubah</small>
                    </div>
                  </div>
                </div>
                
                <div class="mt-4">
                  <button type="submit" class="btn btn-primary me-2">
                    <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
                  </button>
                  <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-x me-2"></i>Batal
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
