<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilai extends Model
{
    use HasFactory;
    protected $table = 'tb_nilai';
    protected $primaryKey ='kd_nilai';
    protected $fillable = ['kd_nilai', 'Nm_mk', 'NIM_mhs', 'nilai'];
    public $timestamps = false;
    protected $keyType = 'string';
}
