<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua warga
        $wargas = Warga::all();
        
        if ($wargas->isEmpty()) {
            $this->command->info('Data warga kosong, silahkan seed WargaSeeder terlebih dahulu!');
            return;
        }

        $categoriesPemasukan = ['Iuran Bulanan', 'Donasi', 'Denda', 'Lainnya'];
        $categoriesPengeluaran = ['Operasional', 'Kebersihan', 'Keamanan', 'Perbaikan', 'Konsumsi', 'Lainnya'];
        
        $transactions = [];
        
        // Buat transaksi pemasukan (50 data)
        for ($i = 0; $i < 50; $i++) {
            $date = Carbon::now()->subDays(rand(1, 90));
            $warga = $wargas->random();
            
            $transactions[] = [
                'head_family_id' => $warga->id,
                'transaction_type' => 'pemasukan',
                'amount' => rand(50000, 500000),
                'category' => $categoriesPemasukan[array_rand($categoriesPemasukan)],
                'description' => 'Pemasukan kas dari ' . $warga->nama,
                'transaction_date' => $date->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Buat transaksi pengeluaran (30 data)
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(rand(1, 90));
            $warga = $wargas->random();
            
            $transactions[] = [
                'head_family_id' => $warga->id,
                'transaction_type' => 'pengeluaran',
                'amount' => rand(100000, 2000000),
                'category' => $categoriesPengeluaran[array_rand($categoriesPengeluaran)],
                'description' => 'Pengeluaran untuk ' . $categoriesPengeluaran[array_rand($categoriesPengeluaran)],
                'transaction_date' => $date->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Transaction::insert($transactions);
        
        $this->command->info('Data transaksi dummy berhasil ditambahkan: ' . count($transactions) . ' transaksi.');
    }
}