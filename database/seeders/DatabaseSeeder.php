<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'For4izen',
            'email' => 'for4izen@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $this->call([
            RoleSeeder::class
        ]);
    }
}
