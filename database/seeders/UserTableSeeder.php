<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'David Gomez',
            'email' => 'dabydat@github.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Abc123456'),
            'remember_token' => Str::random(10),
        ]);
    }
}
