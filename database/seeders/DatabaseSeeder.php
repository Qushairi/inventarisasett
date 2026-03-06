<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@bengkalis.go.id',
        ], [
            'name' => 'Admin Dinas',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        User::query()->updateOrCreate([
            'email' => 'pegawai@bengkalis.go.id',
        ], [
            'name' => 'Pegawai Dinas',
            'password' => 'password123',
            'role' => 'pegawai',
        ]);
    }
}
