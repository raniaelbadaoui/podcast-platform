<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Host;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create Host User
        $hostUser = User::create([
            'first_name' => 'John',
            'last_name' => 'Podcaster',
            'email' => 'host@example.com',
            'password' => Hash::make('host123'),
            'role' => 'host'
        ]);

        // Create Host Profile
        Host::create([
            'name' => 'John Podcaster',
            'bio' => 'Professional podcaster with 5 years experience',
            'email' => 'john@podcast.com',
            'phone' => '+1234567890',
            'user_id' => $hostUser->id
        ]);

        // Create Regular User
        User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user'
        ]);
    }
}