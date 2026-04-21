<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $user->assignRole('super_admin');

        $user1 = User::firstOrCreate(
            ['email' => 'rubica@admin.com'],
            ['name' => 'Evto', 'password' => Hash::make('password')]
        );
        $user1->assignRole('super_admin');

        $user2 = User::firstOrCreate(
            ['email' => 'arya@admin.com'],
            ['name' => 'Arya', 'password' => Hash::make('password')]
        );
        $user2->assignRole('super_admin');

        $user = User::firstOrCreate(
            ['email' => 'user@admin.com'],
            ['name' => 'User Account', 'password' => Hash::make('password')]
        );
        $user->assignRole('user');
    }
}
