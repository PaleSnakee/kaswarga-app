<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('Password123!');

        foreach ([
            ['name' => 'Administrator KASWARGA', 'email' => 'admin@kaswarga.test', 'role' => User::ROLE_ADMIN],
            ['name' => 'Bendahara KASWARGA', 'email' => 'bendahara@kaswarga.test', 'role' => User::ROLE_BENDAHARA],
            ['name' => 'Warga KASWARGA', 'email' => 'warga@kaswarga.test', 'role' => User::ROLE_WARGA],
        ] as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'role' => $account['role'],
                    'password' => $password,
                ],
            );
        }
    }
}
