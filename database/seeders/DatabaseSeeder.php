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
        // User::factory(10)->create();
        
       User::firstOrCreate(
            ['email' => 'ewazalihaidary5@gmail.com'],
            [
                'name' => 'Ewazali',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            SaleSeeder::class,
            SaleItemSeeder::class
        ]);
    }
}
