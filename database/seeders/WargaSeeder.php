<?php

namespace Database\Seeders;

use App\Models\Warga;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dataWarga = [
            [
                'nama' => 'Bapak Ahmad Fauzi',
                'alamat' => 'Jl. Melati No. 12, RT 01/RW 03, Sukamaju',
                'no_telepon' => '081234567890',
            ],
            [
                'nama' => 'Ibu Siti Aminah',
                'alamat' => 'Jl. Kenanga No. 8, RT 02/RW 03, Sukamaju',
                'no_telepon' => '081298765432',
            ],
            [
                'nama' => 'Bapak Budi Santoso',
                'alamat' => 'Jl. Mawar No. 21, RT 04/RW 01, Sukamaju',
                'no_telepon' => '082112223333',
            ],
            [
                'nama' => 'Ibu Dewi Lestari',
                'alamat' => 'Jl. Flamboyan No. 4, RT 03/RW 02, Sukamaju',
                'no_telepon' => '083811112222',
            ],
            [
                'nama' => 'Bapak Rizky Pratama',
                'alamat' => 'Jl. Anggrek No. 17, RT 05/RW 04, Sukamaju',
                'no_telepon' => '085677889900',
            ],
        ];

        foreach ($dataWarga as $warga) {
            Warga::create($warga);
        }
    }
}
