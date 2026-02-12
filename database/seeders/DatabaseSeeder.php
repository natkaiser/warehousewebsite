<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Seed sample suppliers
        Supplier::create([
            'nama' => 'PT Sumber Air',
            'alamat' => 'Jakarta',
            'telepon' => '021-123456',
        ]);

        Supplier::create([
            'nama' => 'CV Bahan Baku Utama',
            'alamat' => 'Bandung',
            'telepon' => '022-987654',
        ]);

        Supplier::create([
            'nama' => 'PT Pabrik Terpercaya',
            'alamat' => 'Surabaya',
            'telepon' => '031-555555',
        ]);
    }
}
