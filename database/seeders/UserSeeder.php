<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@benurq.com'],
            [
                'name' => 'Administrator Toko',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'status' => 'aktif',
            ]
        );

        User::updateOrCreate(
            ['email' => 'pelanggan@gmail.com'],
            [
                'name' => 'Budi Tambak',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '089876543210',
                'address' => 'Tambak Udang Barokah, Blok C No. 4, Lampung',
                'status' => 'aktif',
            ]
        );
    }
}