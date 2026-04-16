<?php

namespace Database\Seeders;

use App\Models\CompetitionCategory;
use App\Models\JudgingCriteria;
use Illuminate\Database\Seeder;

class JudgingCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criteriaMap = [
            'english-storytelling' => [
                ['name' => 'Content & Story Structure', 'description' => 'Clarity of narrative, plot development, creativity, and originality of the story.', 'weight' => 25.00, 'sort_order' => 1],
                ['name' => 'Language & Grammar', 'description' => 'Proper use of English grammar, vocabulary richness, and fluency.', 'weight' => 20.00, 'sort_order' => 2],
                ['name' => 'Delivery & Expression', 'description' => 'Voice projection, intonation, facial expressions, and body language.', 'weight' => 25.00, 'sort_order' => 3],
                ['name' => 'Audience Engagement', 'description' => 'Ability to captivate and maintain audience attention throughout the performance.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Overall Impression', 'description' => 'General impact, confidence, and stage presence of the performer.', 'weight' => 15.00, 'sort_order' => 5],
            ],
            'english-public-speaking' => [
                ['name' => 'Content & Argumentation', 'description' => 'Depth of topic, logical reasoning, evidence, and persuasiveness of arguments.', 'weight' => 25.00, 'sort_order' => 1],
                ['name' => 'Language & Vocabulary', 'description' => 'Grammar accuracy, vocabulary range, and appropriate use of rhetorical devices.', 'weight' => 20.00, 'sort_order' => 2],
                ['name' => 'Delivery & Vocal Variety', 'description' => 'Voice modulation, pace, pronunciation, and effective use of pauses.', 'weight' => 25.00, 'sort_order' => 3],
                ['name' => 'Stage Presence & Confidence', 'description' => 'Eye contact, posture, gestures, and commanding presence on stage.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Overall Impact', 'description' => 'Lasting impression, call to action effectiveness, and audience response.', 'weight' => 15.00, 'sort_order' => 5],
            ],
            'modern-dance' => [
                ['name' => 'Choreography & Creativity', 'description' => 'Originality of dance moves, formations, transitions, and creative expression.', 'weight' => 25.00, 'sort_order' => 1],
                ['name' => 'Technique & Synchronization', 'description' => 'Technical skill, precision, coordination, and synchronization among group members.', 'weight' => 25.00, 'sort_order' => 2],
                ['name' => 'Musicality & Rhythm', 'description' => 'Ability to interpret music, maintain rhythm, and express the song\'s mood.', 'weight' => 20.00, 'sort_order' => 3],
                ['name' => 'Stage Presence & Energy', 'description' => 'Confidence, facial expressions, energy level, and audience engagement.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Costume & Overall Presentation', 'description' => 'Appropriateness of costumes, visual impact, and overall performance quality.', 'weight' => 15.00, 'sort_order' => 5],
            ],
            'korean-calligraphy' => [
                ['name' => 'Stroke Accuracy', 'description' => 'Precision and correctness of Korean character strokes and forms.', 'weight' => 30.00, 'sort_order' => 1],
                ['name' => 'Composition & Layout', 'description' => 'Balance, spacing, alignment, and overall aesthetic arrangement.', 'weight' => 25.00, 'sort_order' => 2],
                ['name' => 'Artistic Expression', 'description' => 'Creative interpretation, personal style, and artistic flair in the calligraphy.', 'weight' => 20.00, 'sort_order' => 3],
                ['name' => 'Neatness & Consistency', 'description' => 'Uniformity of strokes, cleanliness, and consistency across the entire work.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Overall Impression', 'description' => 'General visual impact and appreciation of the completed work.', 'weight' => 10.00, 'sort_order' => 5],
            ],
            'indonesian-storytelling' => [
                ['name' => 'Content & Story Structure', 'description' => 'Story coherence, plot development, creativity, and cultural relevance.', 'weight' => 25.00, 'sort_order' => 1],
                ['name' => 'Bahasa Indonesia Proficiency', 'description' => 'Grammar, pronunciation, vocabulary, and fluency in Bahasa Indonesia.', 'weight' => 25.00, 'sort_order' => 2],
                ['name' => 'Delivery & Expression', 'description' => 'Voice projection, intonation, facial expressions, and gestures.', 'weight' => 20.00, 'sort_order' => 3],
                ['name' => 'Audience Engagement', 'description' => 'Ability to connect with the audience and maintain interest.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Overall Impression', 'description' => 'General impact, effort, and appreciation of the performance.', 'weight' => 15.00, 'sort_order' => 5],
            ],
            'cultural-showcase' => [
                ['name' => 'Cultural Authenticity', 'description' => 'Accuracy of cultural representation and respect for traditions.', 'weight' => 25.00, 'sort_order' => 1],
                ['name' => 'Performance Quality', 'description' => 'Technical skill, preparation, and execution of the showcase.', 'weight' => 25.00, 'sort_order' => 2],
                ['name' => 'Creativity & Presentation', 'description' => 'Creative elements, visual appeal, and overall presentation quality.', 'weight' => 20.00, 'sort_order' => 3],
                ['name' => 'Stage Presence', 'description' => 'Confidence, energy, and audience engagement during performance.', 'weight' => 15.00, 'sort_order' => 4],
                ['name' => 'Overall Impression', 'description' => 'General impact, educational value, and audience appreciation.', 'weight' => 15.00, 'sort_order' => 5],
            ],
        ];

        foreach ($criteriaMap as $slug => $criterias) {
            $category = CompetitionCategory::where('slug', $slug)->first();

            if (!$category) {
                continue;
            }

            foreach ($criterias as $criteria) {
                JudgingCriteria::updateOrCreate(
                    [
                        'competition_category_id' => $category->id,
                        'name' => $criteria['name'],
                    ],
                    $criteria
                );
            }
        }
    }
}
