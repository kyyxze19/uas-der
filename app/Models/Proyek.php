<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';

    protected $fillable = [
        'nama_proyek',
        'lokasi_proyek',
        'klien',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_proyek'
    ];

    public $timestamps = false; // Kalau memang gak ada created_at dan updated_at
}