<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Mahasiswa::create([
            'Nim' => '2141720010',
            'Nama' => 'Augan',
            'Email' => 'ufanis@gmail.com',
            'Tanggal_Lahir' => '35',
            'Jurusan' => 'TI',
            'No_Handphone' => '0999766222'
        ]);
    }
}
