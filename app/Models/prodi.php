<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodi extends Model
{
    use HasFactory;
    protected $table = 'tb_prodi';
    protected $primaryKey ='kd_prodi';
    protected $fillable = ['kd_prodi', 'nm_prodi'];
    public $timestamps = false;
    protected $keyType = 'string';
}
