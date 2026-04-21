<?php

namespace Database\Seeders;

use App\Models\CompetitionCategory;
use App\Models\User;
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

        // Sample jury accounts for testing jury panel and category mapping.
        $jury1 = User::firstOrCreate(
            ['email' => 'jury.story@admin.com'],
            ['name' => 'Jury Story', 'password' => Hash::make('password')]
        );
        $jury1->assignRole('jury');

        $jury2 = User::firstOrCreate(
            ['email' => 'jury.speech@admin.com'],
            ['name' => 'Jury Speech', 'password' => Hash::make('password')]
        );
        $jury2->assignRole('jury');

        $jury3 = User::firstOrCreate(
            ['email' => 'jury.creative@admin.com'],
            ['name' => 'Jury Creative', 'password' => Hash::make('password')]
        );
        $jury3->assignRole('jury');

        // Requirement: each event category has 3 juries assigned.
        $allCategoryIds = CompetitionCategory::query()->pluck('id')->toArray();

        if (! empty($allCategoryIds)) {
            $jury1->assignedCompetitionCategories()->syncWithoutDetaching($allCategoryIds);
            $jury2->assignedCompetitionCategories()->syncWithoutDetaching($allCategoryIds);
            $jury3->assignedCompetitionCategories()->syncWithoutDetaching($allCategoryIds);
        }
    }
}
