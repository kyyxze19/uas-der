<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class matakuliah extends Model
{
    use HasFactory;
    protected $table = 'tb_matkul';
    protected $primaryKey ='Kd_mk';
    protected $fillable = ['Kd_mk', 'Nm_mk', 'sks', 'dosen', 'file'];
    public $timestamps = false;
    protected $keyType = 'string';
}
