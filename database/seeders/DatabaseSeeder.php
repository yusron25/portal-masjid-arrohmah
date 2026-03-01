<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Ensure admin user exists
        User::firstOrCreate(
            ['email' => 'admin@desa.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
            ]
        );

        // Seed village content
        $this->call(VillageSeeder::class);
    }
}
