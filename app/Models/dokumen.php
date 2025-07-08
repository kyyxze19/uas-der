<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'dokumen'; // Nama tabel di database

    /**
     * Primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'id_dokumen'; //

    /**
     * Menandakan jika model harus memiliki timestamps (created_at, updated_at).
     * Dibuat false karena di tabel Anda tidak ada kolom ini.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Kolom-kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id_karyawan', //
        'nama_dokumen', //
        'file_dokumen', //
        'jenis_dokumen', //
        'tanggal_upload', //
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User (Karyawan).
     */
    public function user()
    {
        // Relasi ke model User, dengan foreign key 'id_karyawan'
        return $this->belongsTo(User::class, 'id_karyawan');
    }
}