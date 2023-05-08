<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'test11@mail.ru',
            'email' => 'test11@mail.ru',
            'email_verified_at' => now(),
            'password' => bcrypt('test11@mail.ru'), // password
            'remember_token' => null,
        ]);
    }
}
