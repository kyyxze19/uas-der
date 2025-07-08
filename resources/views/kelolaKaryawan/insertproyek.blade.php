@extends('master')

@section('judul', 'Tambah Proyek')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Tambah Proyek Baru</h3>

    <form action="{{ route('proyek.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_proyek" class="form-label">Nama Proyek</label>
            <input type="text" class="form-control" name="nama_proyek" required>
        </div>

        <div class="mb-3">
            <label for="lokasi_proyek" class="form-label">Lokasi Proyek</label>
            <input type="text" class="form-control" name="lokasi_proyek" required>
        </div>

        <div class="mb-3">
            <label for="klien" class="form-label">Klien</label>
            <input type="text" class="form-control" name="klien">
        </div>

        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" name="tanggal_mulai" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" name="tanggal_selesai" required>
        </div>

        <div class="mb-3">
            <label for="status_proyek" class="form-label">Status</label>
            <select class="form-select" name="status_proyek" required>
                <option value="">-- Pilih Status --</option>
                <option value="Belum Mulai">Belum Mulai</option>
                <option value="Berjalan">Berjalan</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="{{ route('kelola.proyek') }}" class="btn btn-secondary ms-2">Kembali</a>
        </div>
    </form>
</div>
@endsection
