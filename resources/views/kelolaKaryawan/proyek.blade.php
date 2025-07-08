@extends('master')

@section('judul', 'Kelola Proyek')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Daftar Proyek</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('proyek.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Proyek
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Proyek</th>
                <th>Klien</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proyeks as $index => $proyek)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $proyek->nama_proyek }}</td>
                    <td>{{ $proyek->klien ?? '-' }}</td>
                   <td>
                @if($proyek->status_proyek === 'Belum Mulai')
                    <span class="badge bg-danger">Belum Mulai</span> {{-- Merah --}}
                @elseif($proyek->status_proyek === 'Berjalan')
                    <span class="badge bg-warning text-dark">Berjalan</span> {{-- Kuning --}}
                @elseif($proyek->status_proyek === 'Selesai')
                    <span class="badge bg-success">Selesai</span> {{-- Hijau --}}
                @else
                    <span class="badge bg-dark">Tidak Diketahui</span>
                @endif
            </td>
                    <td>
                        {{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d-m-Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d-m-Y') }}
                    </td>
                    <td>
                        <a href="{{ route('proyek.show', $proyek->id_proyek) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('proyek.edit', $proyek->id_proyek) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                     <form action="{{ route('proyek.destroy', $proyek->id_proyek) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin mau hapus proyek ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada proyek.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection