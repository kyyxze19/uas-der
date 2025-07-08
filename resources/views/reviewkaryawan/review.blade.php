@extends('master')

@section('judul', 'Review Karyawan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Daftar Karyawan</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>NIK</th>
        <th>Jenis Kelamin</th>
        <th>Status Keaktifan</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @forelse ($karyawans as $index => $karyawan)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $karyawan->name }}</td>
            <td>{{ $karyawan->email }}</td>
            <td>{{ $karyawan->nik ?? '-' }}</td>
            <td>{{ $karyawan->jenis_kelamin ?? '-' }}</td>
            <td>{{ $karyawan->status_keaktifan ?? '-' }}</td>
            <td>
                
                <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">Belum ada karyawan.</td>
        </tr>
    @endforelse
</tbody>
</table>


   
</div>
@endsection
