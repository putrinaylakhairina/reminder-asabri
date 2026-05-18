<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pensioner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin ASABRI',
            'email' => 'admin@asabri.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Sample Pensioner User 1 (Safe)
        $user1 = User::create([
            'name' => 'Budi Sudarsono',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'asabri',
        ]);

        Pensioner::create([
            'user_id' => $user1->id,
            'nama' => 'Budi Sudarsono',
            'nip' => '1234567890',
            'instansi' => 'POLRI',
            'gaji_pensiun' => 5000000,
            'tanggal_jatuh_tempo' => Carbon::today()->addDays(10),
            'no_hp' => '081234567890',
            'email' => 'budi@example.com',
        ]);

        // Sample Pensioner User 2 (Approaching)
        $user2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'asabri',
        ]);

        Pensioner::create([
            'user_id' => $user2->id,
            'nama' => 'Siti Aminah',
            'nip' => '0987654321',
            'instansi' => 'TNI AD',
            'gaji_pensiun' => 4500000,
            'tanggal_jatuh_tempo' => Carbon::today()->addDays(2),
            'no_hp' => '082164812508',
            'email' => 'siti@example.com',
        ]);

        // Sample Pensioner User 3 (Due)
        $user3 = User::create([
            'name' => 'Agus Santoso',
            'email' => 'agus@example.com',
            'password' => Hash::make('password'),
            'role' => 'asabri',
        ]);

        Pensioner::create([
            'user_id' => $user3->id,
            'nama' => 'Agus Santoso',
            'nip' => '1122334455',
            'instansi' => 'TNI AL',
            'gaji_pensiun' => 4800000,
            'tanggal_jatuh_tempo' => Carbon::today(),
            'no_hp' => '081122334455',
            'email' => 'agus@example.com',
        ]);
    }
}
