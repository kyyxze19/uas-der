<?php

namespace App\Models;

use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'tb_mhs';
    protected $primaryKey ='NIM_mhs';
    protected $fillable = ['NIM_mhs', 'Nm_mhs', 'kd_prodi', 'Jk_mhs', 'No_Hp', 'Email_mhs', 'Foto_mhs'];
    public $timestamps = false;
}
