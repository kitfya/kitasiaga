<?php

namespace Database\Seeders;

use App\Models\Posko;
use App\Models\Relawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@kitasiaga.com',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('Admin#1234'),
        ]);

        Posko::create([
            'name' => 'Posko Polinela',
            'alamat' => 'Jl. Soekarno Hatta',
            'kapasitas' => 2000,
            'jumlah_pengungsi' => 20,
            'latitude' => -5.359842417833,
            'longitude' => 105.22856354713,
        ]);

        User::factory()->create([
            'name' => 'Relawan',
            'email' => 'relawan@kitasiaga.com',
            'phone' => '081234567890',
            'role' => 'relawan',
            'password' => Hash::make('Relawan#1234'),
        ]);

        Relawan::create([
            'user_id' => 2,
            'bidang' => 'logistik',
            'instansi' => 'KitaSiaga',
            'posko_id' => 1,
        ]);
    }
}
