<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan menggunakan model User
use App\Models\Dokumen; // Kita akan butuh ini untuk fitur download
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Diperlukan untuk data karyawan yang login
use Illuminate\Support\Facades\Storage; // Diperlukan untuk download file
use Illuminate\Support\Facades\Log; // Import Log untuk error logging

class KaryawanController extends Controller
{
    // =================================================================
    // == BAGIAN UNTUK ADMIN/HR (KODE ANDA YANG SUDAH ADA) ==
    // =================================================================

    public function kelola()
    {
        // Menampilkan halaman untuk menambah karyawan baru
        return view('kelolaKaryawan.karyawan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|string|max:120|unique:users,nik',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_keaktifan' => 'required|in:Aktif,Tidak Aktif',
            'password' => 'required|string|min:6'
        ]);

        $validated['role'] = 'karyawan';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        // Redirect ke halaman daftar karyawan, bukan form tambah lagi
        return redirect()->route('reviewkaryawan.review')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function review()
    {
        $karyawans = User::where('role', 'karyawan')->get();
        return view('reviewkaryawan.review', compact('karyawans'));
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('reviewkaryawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
            'nik' => 'required|string|max:120|unique:users,nik,' . $karyawan->id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_keaktifan' => 'required|in:Aktif,Tidak Aktif',
            'password' => 'nullable|string|min:6'
        ]);
        
        // Menggunakan array_filter untuk menghapus password jika kosong
        $updateData = $request->only(['name', 'email', 'nik', 'jenis_kelamin', 'status_keaktifan']);
        
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $karyawan->update($updateData);

        return redirect()->route('reviewkaryawan.review')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect("/review-karyawan")->with('success', 'Data karyawan berhasil dihapus.');
    }

    // =================================================================
    // == BAGIAN UNTUK DASHBOARD KARYAWAN (METODE BARU) ==
    // =================================================================

    /**
     * Menampilkan halaman dashboard utama untuk karyawan yang sedang login.
     */
    public function dashboard()
    {
        $karyawan = Auth::user(); // Mengambil data user (karyawan) yang sedang login
        return view('karyawan.dashboard', compact('karyawan'));
    }

    /**
     * Menampilkan form untuk karyawan mengedit data pribadinya.
     */
    public function editPribadi()
    {
        $karyawan = Auth::user();
        return view('karyawan.editpribadi', compact('karyawan'));
    }

    /**
     * Memproses pembaruan data pribadi oleh karyawan.
     */
    public function updatePribadi(Request $request)
    {
        try {
            /** @var \App\Models\User $karyawan */
            $karyawan = Auth::user();

            // Validasi input dengan pesan error yang jelas
            $validatedData = $request->validate([
                'tanggal_lahir' => 'nullable|date|before:today',
                'no_hp'         => 'nullable|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',
                'alamat'        => 'nullable|string|max:500',
            ], [
                'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
                'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
                'no_hp.min' => 'Nomor HP minimal 10 karakter',
                'no_hp.max' => 'Nomor HP maksimal 15 karakter', 
                'no_hp.regex' => 'Format nomor HP tidak valid (hanya angka, +, -, dan spasi)',
                'alamat.max' => 'Alamat maksimal 500 karakter',
            ]);

            // Update data ke database
            $updated = $karyawan->update($validatedData);

            if ($updated) {
                // Pastikan redirect ke dashboard dengan pesan sukses
                return redirect()->route('karyawan.dashboard')
                               ->with('success', 'Data pribadi berhasil diperbarui dan tersimpan ke database!');
            } else {
                return redirect()->route('karyawan.edit_pribadi')
                               ->withInput()
                               ->with('error', 'Gagal menyimpan data ke database. Silakan coba lagi.');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('karyawan.edit_pribadi')
                           ->withErrors($e->validator)
                           ->withInput()
                           ->with('error', 'Terdapat kesalahan dalam pengisian form. Periksa kembali data yang dimasukkan.');
                           
        } catch (\Exception $e) {
            Log::error('Error updating karyawan data: ' . $e->getMessage());
            return redirect()->route('karyawan.edit_pribadi')
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi administrator.');
        }
    }


    /**
     * Menampilkan halaman daftar dokumen untuk di-download.
     */
        public function showDokumen()
    {
        $karyawanId = Auth::id();
        // Ganti 'user_id' menjadi 'id_karyawan'
        $dokumens = Dokumen::where('id_karyawan', $karyawanId)->get(); 
        return view('karyawan.dokumen', compact('dokumens'));
    }
    /**
     * Memproses permintaan download dokumen.
     */
    public function downloadDokumen($id)
    {
        $dokumen = Dokumen::where('id', $id)
                          ->where('user_id', Auth::id()) // Keamanan: pastikan karyawan hanya bisa download file miliknya
                          ->firstOrFail();
                          
        // Pastikan path file di storage benar. Contoh: 'public/dokumen_karyawan/namafile.pdf'
        return Storage::download($dokumen->file_path, $dokumen->nama_dokumen);
    }
}