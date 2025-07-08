<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\mahasiswa;
use Faker\Factory as A;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $x = A::create('fr_FR');
        for($i=0; $i<15; $i++)
        {
        mahasiswa::Create([
            'NIM_mhs' => $x->numerify(string:'2023 ###'),
            'Nm_mhs' => $x->name,
           'kd_prodi' => $x->randomElement(['TRPL', 'MKT', 'MESIN', 'LISTRIK']),
            'Jk_mhs' => $x->randomElement(['LAKI-LAKI', 'PEREMPUAN']),
            'No_Hp' => $x-> phoneNumber,
            'Email_mhs' => $x->email, 
        ]);
            }
    }
}
