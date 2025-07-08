@extends('master')

@section('judul')
  Profil Saya
@endsection

@section('subjudul')
  Data Pribadi
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Profil Saya</h5>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
              <i class="ti ti-edit me-2"></i>Edit Profil
            </a>
          </div>
        </div>
        <div class="card-body">
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
                    <p class="mb-0">{{ $user->nik }}</p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Email</label>
                    <p class="mb-0">{{ $user->email }}</p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Jenis Kelamin</label>
                    <p class="mb-0">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Tanggal Lahir</label>
                    <p class="mb-0">{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d/m/Y') : '-' }}</p>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Alamat</label>
                    <p class="mb-0">{{ $user->alamat ?: '-' }}</p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">No. HP</label>
                    <p class="mb-0">{{ $user->no_hp ?: '-' }}</p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Status Keaktifan</label>
                    <p class="mb-0">
                      <span class="badge bg-{{ $user->status_keaktifan == 'aktif' ? 'success' : 'danger' }}">
                        {{ ucfirst($user->status_keaktifan) }}
                      </span>
                    </p>
                  </div>
                  
                  <div class="mb-3">
                    <label class="form-label text-muted fw-semibold">Tanggal Masuk</label>
                    <p class="mb-0">{{ $user->tanggal_masuk ? \Carbon\Carbon::parse($user->tanggal_masuk)->format('d/m/Y') : '-' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
