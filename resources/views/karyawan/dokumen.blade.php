{{-- simpan sebagai resources/views/karyawan/upload_dokumen.blade.php --}}
@extends('master_karyawan')

@section('judul', 'Upload Dokumen')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h4 class="mb-0">Upload Dokumen Baru</h4>
        </div>
        <div class="card-body">
            <p>Silakan pilih file yang ingin Anda unggah. Pastikan format file adalah PDF, DOCX, JPG, atau PNG dengan ukuran maksimal 2MB.</p>
            
            <form action="{{ route('karyawan.proses_upload') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_dokumen" class="form-label">Nama Dokumen</label>
                    <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen" name="nama_dokumen" value="{{ old('nama_dokumen') }}" placeholder="Contoh: KTP, Ijazah S1, Kontrak Kerja">
                    @error('nama_dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="file_dokumen" class="form-label">Pilih File</label>
                    <input class="form-control @error('file_dokumen') is-invalid @enderror" type="file" id="file_dokumen" name="file_dokumen">
                    @error('file_dokumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="ti ti-upload me-1"></i> Unggah File
                    </button>
                    <a href="{{ route('karyawan.dokumen') }}" class="btn btn-secondary px-4 py-2 ms-2">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection