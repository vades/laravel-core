<?php
// Path: database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // We manually assign the project_id we just found/created.
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Search Key
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),

                // Specific fields for your login testing
                // In database/factories/UserFactory.php
                'project_id' => Project::where('slug', 'laravel-core')->first()->id,
                'role' => 'admin',     // Override random factory default
                'account_type' => 'pro', // Override random factory default
                'metadata' => ['is_super_admin' => true],
            ]
        );
    }
}