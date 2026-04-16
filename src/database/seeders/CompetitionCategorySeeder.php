<?php

namespace Database\Seeders;

use App\Models\CompetitionCategory;
use Illuminate\Database\Seeder;

class CompetitionCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'English Storytelling',
                'slug' => 'english-storytelling',
                'description' => 'Narrate compelling stories that captivate and inspire global audiences.',
                'icon' => 'auto_stories',
                'type' => 'individual',
                'price_national' => 50000,
                'price_international' => 0,
                'is_national' => true,
                'is_international' => true,
                'is_active' => true,
            ],
            [
                'name' => 'English Public Speaking',
                'slug' => 'english-public-speaking',
                'description' => 'Master the art of persuasion and deliver powerful speeches with impact.',
                'icon' => 'record_voice_over',
                'type' => 'individual',
                'price_national' => 50000,
                'price_international' => 0,
                'is_national' => true,
                'is_international' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Modern Dance',
                'slug' => 'modern-dance',
                'description' => 'Express movement and rhythm through contemporary and urban choreography.',
                'icon' => 'theater_comedy',
                'type' => 'group',
                'price_national' => 75000,
                'price_international' => 0,
                'is_national' => true,
                'is_international' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Korean Calligraphy',
                'slug' => 'korean-calligraphy',
                'description' => 'Celebrate diversity through traditional Korean calligraphy art.',
                'icon' => 'draw',
                'type' => 'individual',
                'price_national' => 50000,
                'price_international' => 0,
                'is_national' => true,
                'is_international' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Indonesian Storytelling',
                'slug' => 'indonesian-storytelling',
                'description' => 'Exclusively for non-Indonesian students to craft narratives in Bahasa Indonesia.',
                'icon' => 'translate',
                'type' => 'individual',
                'price_national' => 0,
                'price_international' => 0,
                'is_national' => false,
                'is_international' => true,
                'is_active' => true,
            ],
            // [
            //     'name' => 'Cultural Showcase',
            //     'slug' => 'cultural-showcase',
            //     'description' => 'Celebrate diversity through traditional performances and exhibitions.',
            //     'icon' => 'diversity_3',
            //     'type' => 'individual',
            //     'price_national' => 50000,
            //     'price_international' => 0,
            //     'is_national' => true,
            //     'is_international' => false,
            //     'is_active' => true,
            // ],
        ];

        foreach ($categories as $category) {
            CompetitionCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
