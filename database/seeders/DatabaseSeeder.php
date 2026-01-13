<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
                        ProjectSeeder::class,
                        UserSeeder::class,

                    ]);

        if (app()->environment('local')) {
            $this->call([
                            CategorySeeder::class,
                            TagSeeder::class,
                            InquirySeeder::class,
                            ContentSeeder::class,

                        ]);

        }
    }
}