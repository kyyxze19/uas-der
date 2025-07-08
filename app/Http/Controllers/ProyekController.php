<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;

class ProyekController extends Controller
{
    // Tampilkan daftar proyek
    public function index()
    {
        $proyeks = Proyek::all();
        return view('kelolakaryawan.proyek', compact('proyeks'));
    }

    // Tampilkan form tambah proyek
    public function create()
    {
        return view('kelolakaryawan.insertproyek');
    }

    // Simpan data proyek ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:100',
            'lokasi_proyek' => 'required|string|max:150',
            'klien' => 'nullable|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_proyek' => 'required|in:Belum Mulai,Berjalan,Selesai'
        ]);

        // Simpan ke database
        Proyek::create($validated);

        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil ditambahkan!');
    }
    public function destroy($id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();

        return redirect()->route('kelola.proyek')->with('success', 'Proyek berhasil dihapus.');
    }

    public function edit($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('kelolakaryawan.editproyek', compact('proyek'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_proyek' => 'required|string|max:100',
            'lokasi_proyek' => 'required|string|max:150',
            'klien' => 'nullable|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status_proyek' => 'required|in:Belum Mulai,Berjalan,Selesai',
        ]);

        $proyek = Proyek::findOrFail($id);
        $proyek->update($validated);

        return redirect()->route('kelola.proyek')->with('success', 'Data proyek berhasil diperbarui!');
    }

    public function show($id)
    {
        $proyek = Proyek::findOrFail($id);
        return view('kelolaKaryawan.showproyek', compact('proyek'));
    }

}