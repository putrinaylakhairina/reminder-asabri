<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['nomor_registrasi' => 'ADMIN-00001'],
            [
                'nama' => 'Admin',
                'asal_sekolah' => 'Kantor Polisi',
                'nisn' => '0000000000',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true
            ]
        );
    }
}
