<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // [
            //     'question' => 'What is default password?',
            //     'answer' => 'The default password is provided during the registration process. Password will be ueuevent2026 for the initial password and change it upon first login.',
            //     'sort_order' => 1,
            // ],
            [
                'question' => 'What is the Esa Unggul International Event 2026?',
                'answer' => 'The Esa Unggul International Event 2026 is a prestigious academic and creative competition organized by Lembaga Bahasa dan Kebudayaan Universitas Esa Unggul. It features Storytelling (English & Bahasa Indonesia) and Public Speaking competitions, bringing together talented students from Indonesia and around the world.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Who can participate in this event?',
                'answer' => 'The National competition is open to Senior High School students (SMA/SMK Sederajat) across Indonesia. The International competition is open to active university students (Diploma, Undergraduate, or Postgraduate) from both local and international institutions.',
                'sort_order' => 3,
            ],
            [
                'question' => 'What competition categories are available?',
                'answer' => 'There are three main categories: Storytelling in English (for university students), Storytelling in Bahasa Indonesia (for foreign university students), and Public Speaking in English (for university students). National level participants have dedicated tracks as well.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Is there a registration fee?',
                'answer' => 'International participants can register for free. National participants have a registration fee that varies by competition category. Please check the registration page for the latest pricing details.',
                'sort_order' => 5,
            ],
            [
                'question' => 'What is the mandatory Zoom Workshop?',
                'answer' => 'All registered participants must attend a mandatory Zoom Workshop & Provision session. This includes a Pre-Event Workshop, Provision Session, announcement of official themes, and a Q&A session. Absence without prior confirmation may result in disqualification.',
                'sort_order' => 6,
            ],
            [
                'question' => 'How does the selection process work?',
                'answer' => 'After the workshop, participants submit a video of their performance. Videos are evaluated by a panel of judges based on specific criteria. Top performers are selected as finalists and will compete in the Grand Final event either onsite or online.',
                'sort_order' => 7,
            ],
            [
                'question' => 'Can I participate online in the Grand Final?',
                'answer' => 'Yes! The Grand Final supports both onsite participation at Kemala Ballroom, Universitas Esa Unggul, Jakarta, and online participation via Zoom. All finalists must attend the Technical Meeting prior to the Grand Final.',
                'sort_order' => 8,
            ],
            [
                'question' => 'What are the video submission requirements?',
                'answer' => 'Videos must be recorded in one continuous take with no editing or cuts. Minimum quality is 720p (HD). Participants must introduce themselves and mention the story/speech title at the beginning. No scripts or cue cards are allowed (except for Public Speaking). Full details are on the Rules page.',
                'sort_order' => 9,
            ],
            [
                'question' => 'When will the finalists be announced?',
                'answer' => 'Finalists will be announced after the selection process is completed. Please refer to our timeline on the Rules page for exact dates. Selected finalists will be contacted directly and announced on our official channels.',
                'sort_order' => 10,
            ],
            [
                'question' => 'How can I contact the organizing committee?',
                'answer' => 'You can reach us via email at lbk@esaunggul.ac.id. Our office is located at Gedung A, R.416-417, Lantai 4, Jl. Arjuna Utara No.9, Kebon Jeruk, Jakarta 11510. Feel free to contact us for any questions or concerns.',
                'sort_order' => 11,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
