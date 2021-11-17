<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        for ($i=0; $i <50; $i++) {
            User::insert([
                'name' => Str::random(12),
                'email' => Str::random(8).'@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
        }

    }
}
