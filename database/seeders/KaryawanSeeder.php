<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user karyawan contoh
        User::create([
            'name' => 'Karyawan 1',
            'email' => 'karyawan1@animart.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);

        User::create([
            'name' => 'Karyawan 2',
            'email' => 'karyawan2@animart.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
    }
}
