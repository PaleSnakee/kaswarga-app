<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $dataPengumuman = [
            [
                'judul' => 'Kerja bakti lingkungan',
                'isi' => 'Kerja bakti akan dilaksanakan hari Minggu pukul 07.00 WIB. Mohon setiap Kepala Keluarga mengirimkan satu perwakilan.',
            ],
            [
                'judul' => 'Pembayaran iuran bulanan',
                'isi' => 'Batas akhir pembayaran iuran bulan ini jatuh pada tanggal 10. Silakan lakukan konfirmasi ke bendahara setelah transfer.',
            ],
            [
                'judul' => 'Pendataan kepala keluarga baru',
                'isi' => 'Kepala keluarga yang baru pindah dimohon melapor ke pengurus RT agar data administrasi segera diperbarui.',
            ],
        ];

        foreach ($dataPengumuman as $pengumuman) {
            Pengumuman::updateOrCreate(
                ['judul' => $pengumuman['judul']],
                ['isi' => $pengumuman['isi']]
            );
        }
    }
}
