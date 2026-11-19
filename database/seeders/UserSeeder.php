<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jan Dexter Diaz',
            'email' => 'diaz@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        User::create([
            'name' => 'Tita Diaz',
            'email' => 'tita.diaz@kaonta.test',
            'password' => Hash::make('kaonta2026'),
        ]);

        // 10 more random users
        User::factory(10)->create();
    }
}
