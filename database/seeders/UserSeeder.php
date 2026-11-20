<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create one admin
        User::factory()->admin()->create([
            'name' => 'Ewazali',
            'email' => 'ewwazalihaidary5@gmail.com',
        ]);

        // Create 10 employees
        User::factory(10)->create();
    }
}