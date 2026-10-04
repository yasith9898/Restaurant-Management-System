<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@baklavainn.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);


        User::create([
            'name' => 'Manager',
            'email' => 'manager@baklavainn.com',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
        ]);
    }
}
