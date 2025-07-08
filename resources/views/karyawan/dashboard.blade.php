@extends('master_karyawan')

@section('judul', 'Dashboard Saya')

@section('content')
<div class="container-fluid">
    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Foto Profil"
                         class="img-fluid rounded-circle mb-3" width="120">
                    <h4 class="card-title">{{ $karyawan->name }}</h4>
                    <p class="text-muted mb-4">{{ $karyawan->email }}</p>
                    
                    <a href="{{ route('karyawan.edit_pribadi') }}" class="btn btn-warning w-100 mb-2">
                        <i class="ti ti-pencil me-1"></i> Edit Data Pribadi
                    </a>
                </div>
            </div>
            
            <div class="card shadow-sm">
                 <div class="card-body">
                     <h5 class="card-title mb-3">Navigasi Cepat</h5>
                     <div class="list-group">
                         <a href="{{ route('karyawan.dokumen') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                             Download Dokumen
                             <i class="ti ti-download"></i>
                         </a>
                         <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                             Upload Dokumen
                             <i class="ti ti-upload"></i>
                         </a>
                     </div>
                 </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Informasi Detail Karyawan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-id-badge-2 me-3 fs-5 text-primary"></i>
                                <strong>NIK</strong>
                            </div>
                            <span>{{ $karyawan->nik ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                             <div class="d-flex align-items-center">
                                <i class="ti ti-users me-3 fs-5 text-primary"></i>
                                <strong>Jenis Kelamin</strong>
                            </div>
                            <span>{{ $karyawan->jenis_kelamin ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                             <div class="d-flex align-items-center">
                                <i class="ti ti-calendar-event me-3 fs-5 text-primary"></i>
                                <strong>Tanggal Lahir</strong>
                            </div>
                            <span>{{ $karyawan->tanggal_lahir ? \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d F Y') : '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-phone me-3 fs-5 text-primary"></i>
                                <strong>Nomor Telepon</strong>
                            </div>
                            <span>{{ $karyawan->nomor_telepon ?? 'Belum diisi' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                               <i class="ti ti-map-pin me-3 fs-5 text-primary"></i>
                                <strong>Alamat</strong>
                            </div>
                           <span class="text-end" style="max-width: 70%;">{{ $karyawan->alamat ?? 'Belum diisi' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-toggle-right me-3 fs-5 text-primary"></i>
                                <strong>Status Karyawan</strong>
                            </div>
                            <span>
                                @if($karyawan->status_keaktifan == 'Aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection