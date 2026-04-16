<?php

namespace Database\Seeders;

use App\Models\EventSetting;
use Illuminate\Database\Seeder;

class EventSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ============ GENERAL ============
            ['key' => 'site_title', 'value' => 'Esa Unggul International Event 2026', 'group' => 'general', 'type' => 'text', 'label' => 'Site Title'],
            ['key' => 'site_description', 'value' => 'A global stage for talent, innovation, and academic excellence.', 'group' => 'general', 'type' => 'textarea', 'label' => 'Site Description'],
            ['key' => 'organizer_name', 'value' => 'Lembaga Bahasa dan Kebudayaan Universitas Esa Unggul', 'group' => 'general', 'type' => 'text', 'label' => 'Organizer Name'],

            // ============ CONTACT ============
            ['key' => 'contact_email', 'value' => 'lbk@esaunggul.ac.id', 'group' => 'contact', 'type' => 'text', 'label' => 'Contact Email'],
            ['key' => 'contact_phone', 'value' => '', 'group' => 'contact', 'type' => 'text', 'label' => 'Contact Phone'],
            ['key' => 'contact_location', 'value' => 'Jakarta, Indonesia', 'group' => 'contact', 'type' => 'text', 'label' => 'Location'],
            ['key' => 'contact_address', 'value' => 'Gedung A, R.416-417, Lantai 4, Jl. Arjuna Utara No.9, Kebon Jeruk, Jakarta 11510', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Full Address'],
            ['key' => 'footer_description', 'value' => 'Empowering global students to achieve excellence through international collaboration and healthy competition.', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Footer Description'],

            // ============ PAYMENT ============
            ['key' => 'bank_name', 'value' => 'BNI', 'group' => 'payment', 'type' => 'text', 'label' => 'Bank Name'],
            ['key' => 'bank_account_number', 'value' => '0218392241', 'group' => 'payment', 'type' => 'text', 'label' => 'Account Number'],
            ['key' => 'bank_account_name', 'value' => 'Universitas Esa Unggul', 'group' => 'payment', 'type' => 'text', 'label' => 'Account Name'],

            // ============ HOME PAGE ============
            ['key' => 'hero_title', 'value' => 'ESA UNGGUL <span class="text-[#0D5DA6]">INTERNATIONAL</span> EVENT 2026', 'group' => 'home', 'type' => 'text', 'label' => 'Hero Title'],
            ['key' => 'hero_subtitle', 'value' => 'International Event', 'group' => 'home', 'type' => 'text', 'label' => 'Hero Subtitle'],
            ['key' => 'hero_description', 'value' => 'Organized by Lembaga Bahasa dan Kebudayaan Universitas Esa Unggul. A global stage for talent, innovation, and academic excellence.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Hero Description'],
            ['key' => 'hero_badge_text', 'value' => 'Grand Final: June 10-11, 2026', 'group' => 'home', 'type' => 'text', 'label' => 'Badge Text'],
            ['key' => 'hero_image', 'value' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuARnuxzzUsWWtV9i_oaWvvJAnlR1KtVVdVaaToWO-NVoGm6iEnFYF16fAu844vPLVC6n-8ob1L4MV9JA1Sy8_aF5-Lm5BzB3oyqsD4gzzIgS_1GOGwVJM67uLBYEgL9rzhTXXN5fFegesYDKy6H-EV3t5eslZHdgumP43nzibR-T2BjbJ9dxaLt1F9b32hL-s-u2TIHJ5sFNxMnJmpfbTiCrnodQUDY28xkixnD3JeQtw3i2aLUJsfcWbdng5CmvETzBTaI8KPBCMk', 'group' => 'home', 'type' => 'text', 'label' => 'Hero Image URL'],
            ['key' => 'road_image', 'value' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3gA6vKtUlBFvVZ2IiqMMPLbe5mvxIdISzjv6qSYMeHVYYzhzekRkrSW40xXnTdv7k6B-qidsPtTdZqvsj8S9ustyJZxhkqtU2mxQxTOrONActy-MWUo2yUmS2kkG9mlDvNYd37hJyLDCh-WuYDvArJGMn0LF1WaUxX5QhOMSfkUwaSpyXccgRSOHG9AJv5am5QBex43noRGVp-RST1BFK3kgl8tjf0fgPWd4_zsAGCpVI3gcV3has7oBoJAQSy1W2ksjRHo9wfMw', 'group' => 'home', 'type' => 'text', 'label' => 'Road to Excellence Image URL'],
            ['key' => 'highlights_title', 'value' => 'A Global Community', 'group' => 'home', 'type' => 'text', 'label' => 'Highlights Title'],
            ['key' => 'highlights_description', 'value' => 'Bridging excellence across borders. We bring together the brightest minds from across Indonesia and the world.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Highlights Description'],
            ['key' => 'national_card_title', 'value' => 'National Excellence', 'group' => 'home', 'type' => 'text', 'label' => 'National Card Title'],
            ['key' => 'national_card_description', 'value' => 'Dedicated tracks for Senior High School students across Indonesia to showcase their creative and academic prowess.', 'group' => 'home', 'type' => 'textarea', 'label' => 'National Card Description'],
            ['key' => 'global_card_title', 'value' => 'Global Reach', 'group' => 'home', 'type' => 'text', 'label' => 'Global Card Title'],
            ['key' => 'global_card_description', 'value' => 'University students globally are invited to compete on the international stage.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Global Card Description'],
            ['key' => 'global_card_stat', 'value' => '50+', 'group' => 'home', 'type' => 'text', 'label' => 'Global Stat'],
            ['key' => 'global_card_stat_label', 'value' => 'Countries Participating', 'group' => 'home', 'type' => 'text', 'label' => 'Stat Label'],
            ['key' => 'categories_title', 'value' => 'Competition Categories', 'group' => 'home', 'type' => 'text', 'label' => 'Categories Title'],
            ['key' => 'categories_description', 'value' => 'Diverse arenas to challenge your skills and express your creativity.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Categories Description'],
            ['key' => 'road_title', 'value' => 'Road to Excellence', 'group' => 'home', 'type' => 'text', 'label' => 'Road Section Title'],
            ['key' => 'workshop_label', 'value' => 'Zoom Workshop', 'group' => 'home', 'type' => 'text', 'label' => 'Workshop Label'],
            ['key' => 'workshop_description', 'value' => 'Intensive technical coaching and briefing session for all registered participants.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Workshop Description'],
            ['key' => 'final_day1_label', 'value' => 'Grand Final Day 1', 'group' => 'home', 'type' => 'text', 'label' => 'Final Day 1 Label'],
            ['key' => 'final_day1_description', 'value' => 'Opening ceremony and preliminary rounds of international competitions.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Day 1 Description'],
            ['key' => 'final_day2_label', 'value' => 'Grand Final & Awards', 'group' => 'home', 'type' => 'text', 'label' => 'Final Day 2 Label'],
            ['key' => 'final_day2_description', 'value' => 'The final showcase and prestigious awarding ceremony for all winners.', 'group' => 'home', 'type' => 'textarea', 'label' => 'Day 2 Description'],

            // ============ DATES & TIMELINE ============
            ['key' => 'registration_start', 'value' => '28 February 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Registration Start'],
            ['key' => 'registration_end', 'value' => '1 May 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Registration End'],
            ['key' => 'workshop_date', 'value' => 'MAY 04', 'group' => 'dates', 'type' => 'text', 'label' => 'Workshop Date'],
            ['key' => 'workshop_time', 'value' => '08:00 AM WIB', 'group' => 'dates', 'type' => 'text', 'label' => 'Workshop Time'],
            ['key' => 'video_submission_start', 'value' => '5 May 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Video Submission Start'],
            ['key' => 'video_submission_end', 'value' => '25 May 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Video Submission End'],
            ['key' => 'selection_start', 'value' => '26 May 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Selection Start'],
            ['key' => 'selection_end', 'value' => '1 June 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Selection End'],
            ['key' => 'finalist_announcement', 'value' => '2 June 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Finalist Announcement'],
            ['key' => 'technical_meeting_date', 'value' => 'June 6, 2026', 'group' => 'dates', 'type' => 'text', 'label' => 'Technical Meeting Date'],
            ['key' => 'technical_meeting_time', 'value' => '8:00 AM (Jakarta\'s time)', 'group' => 'dates', 'type' => 'text', 'label' => 'Technical Meeting Time'],
            ['key' => 'grand_final_day1', 'value' => 'JUN 10', 'group' => 'dates', 'type' => 'text', 'label' => 'Grand Final Day 1'],
            ['key' => 'grand_final_day2', 'value' => 'JUN 11', 'group' => 'dates', 'type' => 'text', 'label' => 'Grand Final Day 2'],
            ['key' => 'submission_deadline', 'value' => 'MAY 25', 'group' => 'dates', 'type' => 'text', 'label' => 'Submission Deadline'],
            ['key' => 'registration_open', 'value' => '1', 'group' => 'dates', 'type' => 'toggle', 'label' => 'Registration Open'],
            ['key' => 'venue_onsite', 'value' => 'Kemala Ballroom, Universitas Esa Unggul, Jakarta', 'group' => 'dates', 'type' => 'text', 'label' => 'Onsite Venue'],
            ['key' => 'venue_online', 'value' => 'Zoom (link will be provided)', 'group' => 'dates', 'type' => 'text', 'label' => 'Online Platform'],

            // ============ STORYTELLING ENGLISH ============
            ['key' => 'st_en_title', 'value' => 'Storytelling Competition (English)', 'group' => 'storytelling_en', 'type' => 'text', 'label' => 'Title'],
            ['key' => 'st_en_category', 'value' => 'University Students', 'group' => 'storytelling_en', 'type' => 'text', 'label' => 'Category'],
            ['key' => 'st_en_general_info', 'value' => "The competition is open to active university students (Diploma, Undergraduate, or Postgraduate), both local and international.\nParticipants must ensure that all submitted registration data is accurate and valid.\nBy registering, participants agree to comply with all rules and regulations stated in this document.", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'General Info'],
            ['key' => 'st_en_registration_rules', 'value' => "Registration must be completed through the registration link provided by the committee.\nThe participants must upload a student ID card and a formal photograph with a shirt (or official varsity jacket if any).", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Registration Rules'],
            ['key' => 'st_en_zoom_date', 'value' => 'May 4, 2026 at 08:00 AM (Jakarta\'s time)', 'group' => 'storytelling_en', 'type' => 'text', 'label' => 'Zoom Date'],
            ['key' => 'st_en_zoom_includes', 'value' => "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official storytelling theme\nQuestion & Answer session", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Zoom Includes'],
            ['key' => 'st_en_theme_rules', 'value' => "Participants must choose one original folktale from their country of origin.\nThe story must be delivered in English.", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Theme Rules'],
            ['key' => 'st_en_video_duration', 'value' => 'Minimum 3 minutes – Maximum 5 minutes', 'group' => 'storytelling_en', 'type' => 'text', 'label' => 'Video Duration'],
            ['key' => 'st_en_video_rules', 'value' => "The participants must join the provision session on Zoom Meeting.\nThe storytelling performance must be delivered fully in English.\nDuration: Minimum 3 minutes – Maximum 5 minutes.\nThe video may be recorded using Zoom or any other recording platform.\nThe registered participants must submit the video using YouTube or Google Drive link to the submission form provided by the committee.\nVideo quality must be at least 720p (HD).\nThe video must be recorded in one take (no editing, no cuts, no background effects).\nParticipants are not allowed to receive assistance from any other person during recording.\nParticipants must introduce themselves (full name and university), mention the title of the story. These must be stated at the beginning of the video.\nParticipants are not allowed to read from scripts, cue cards, or notes.\nThe use of properties (props) is allowed to support storytelling.\nAudio must be clear and free from disturbing background noise.\nThe content of the story must not contain elements related to SARA (ethnicity, religion, race, inter-group conflict), discrimination, or harmful stereotyping.", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Video Rules'],
            ['key' => 'st_en_judging', 'value' => "Story Mastery & Content Understanding|30%\nPronunciation & Intonation|20%\nFacial Expression & Body Language|20%\nCreativity & Use of Props|20%\nTime Management|10%", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Judging Criteria'],
            ['key' => 'st_en_grand_final', 'value' => "Finalists must perform LIVE (onsite or online) in front of the judges and audience.\nThe story must be the same as the one submitted in the preliminary round.\nThe duration of the performance is 3–5 minutes.\nMore elaborate props are allowed, but no digital background or pre-recorded audio.\nParticipants must attend the technical meeting; absence may result in disqualification.", 'group' => 'storytelling_en', 'type' => 'textarea', 'label' => 'Grand Final Rules'],

            // ============ STORYTELLING BAHASA ============
            ['key' => 'st_id_title', 'value' => 'Storytelling Competition (Bahasa Indonesia)', 'group' => 'storytelling_id', 'type' => 'text', 'label' => 'Title'],
            ['key' => 'st_id_category', 'value' => 'Foreign University Students', 'group' => 'storytelling_id', 'type' => 'text', 'label' => 'Category'],
            ['key' => 'st_id_general_info', 'value' => "The competition is open to active foreign university students (non-Indonesian citizens) currently enrolled in higher education institutions.\nParticipants may be: International students studying in Indonesia, or Students studying outside Indonesia.\nParticipants must ensure that all submitted registration data is accurate and valid.\nBy registering, participants agree to comply with all competition rules and regulations.\nJudges' decisions are final and cannot be contested.", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'General Info'],
            ['key' => 'st_id_registration_rules', 'value' => "Registration must be completed through the official registration link provided by the committee.", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Registration Rules'],
            ['key' => 'st_id_registration_uploads', 'value' => "Student ID Card\nCopy of passport (for nationality verification)\nA formal photograph wearing a shirt (or official varsity jacket)", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Registration Uploads'],
            ['key' => 'st_id_zoom_date', 'value' => 'May 4, 2026 at 08:00 AM (Jakarta\'s time)', 'group' => 'storytelling_id', 'type' => 'text', 'label' => 'Zoom Date'],
            ['key' => 'st_id_zoom_includes', 'value' => "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official storytelling theme\nQuestion & Answer session", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Zoom Includes'],
            ['key' => 'st_id_themes', 'value' => "Situ Bagendit\nKeong Mas\nBatu Menangis", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Story Themes'],
            ['key' => 'st_id_theme_rules', 'value' => "Participants must create an original storytelling performance related to Indonesian culture, values, folklore, or contemporary social themes.\nThe story must be delivered fully in Bahasa Indonesia.", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Theme Rules'],
            ['key' => 'st_id_video_duration', 'value' => 'Minimum 4 minutes – Maximum 7 minutes', 'group' => 'storytelling_id', 'type' => 'text', 'label' => 'Video Duration'],
            ['key' => 'st_id_video_rules', 'value' => "Duration: Minimum 4 minutes – Maximum 7 minutes.\nVideo quality must be at least 720p (HD).\nThe video must be recorded in one continuous take (no cuts, no editing, no visual effects).\nParticipants must: Introduce themselves (full name, university, country of origin), Mention the story title, Declare that the story is original.\nNo scripts, cue cards, or visible notes are allowed.\nNo assistance from other individuals is permitted.\nPhysical props are allowed.\nBackground music, dubbing, subtitles, or sound effects are not allowed.\nAudio must be clear and free from disturbances.\nContent must not contain SARA elements, discrimination, political propaganda, or harmful stereotypes.", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Video Rules'],
            ['key' => 'st_id_judging', 'value' => "Story Mastery & Content Understanding|30%\nPronunciation & Intonation|20%\nFacial Expression & Body Language|20%\nCreativity & Use of Props|20%\nTime Management|10%", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Judging Criteria'],
            ['key' => 'st_id_grand_final', 'value' => "Finalists must perform LIVE (onsite or online) in front of the judges and audience.\nThe story must be the same as the one submitted in the preliminary round.\nThe duration of the performance is 3–5 minutes.\nMore elaborate props are allowed, but no digital background or pre-recorded audio.\nParticipants must attend the technical meeting; absence may result in disqualification.", 'group' => 'storytelling_id', 'type' => 'textarea', 'label' => 'Grand Final Rules'],

            // ============ PUBLIC SPEAKING ============
            ['key' => 'ps_title', 'value' => 'Public Speaking Competition (English)', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Title'],
            ['key' => 'ps_category', 'value' => 'University Students', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Category'],
            ['key' => 'ps_general_info', 'value' => "The competition is open to active university students (Diploma or undergraduate), both local and international.\nParticipants must ensure that all registration data is accurate and valid.\nBy registering, participants agree to comply with all rules and regulations stated in this document.\nJudges' decisions are final and cannot be contested.", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'General Info'],
            ['key' => 'ps_registration_rules', 'value' => "Registration must be completed through the official registration link provided by the committee.", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Registration Rules'],
            ['key' => 'ps_registration_uploads', 'value' => "Student ID Card\nCopy of passport (for nationality verification)\nA formal photograph wearing a shirt (or official varsity jacket)", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Registration Uploads'],
            ['key' => 'ps_zoom_date', 'value' => 'May 4, 2026 at 08:00 AM (Jakarta\'s time)', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Zoom Date'],
            ['key' => 'ps_zoom_includes', 'value' => "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official speech theme\nQuestion & Answer session", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Zoom Includes'],
            ['key' => 'ps_theme_preliminary', 'value' => 'AI as a Partner, Not a Threat: New Perspective', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Preliminary Theme'],
            ['key' => 'ps_theme_final', 'value' => 'Why the Future Needs Human Creativity Alongside AI', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Grand Final Theme'],
            ['key' => 'ps_video_duration', 'value' => 'Minimum 4 minutes – Maximum 6 minutes', 'group' => 'public_speaking', 'type' => 'text', 'label' => 'Video Duration'],
            ['key' => 'ps_video_rules', 'value' => "Duration: Minimum 4 minutes – Maximum 6 minutes.\nThe participants must submit the video using YouTube or Google Drive link to the submission form.\nVideo quality must be at least 720p (HD).\nThe video must be recorded in one continuous take (no cuts, no editing, no visual effects).\nParticipants must: Introduce themselves (full name and university), Mention the speech title.\nReading directly from a script during recording is prohibited.\nCue cards are allowed.\nWearing a school uniform in the recording is required.\nPowerPoint slides, digital backgrounds, background music, or sound effects are not permitted.\nAudio must be clear and free from disturbances.\nContent must not contain SARA elements, hate speech, discrimination, political campaigning, or harmful stereotypes.", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Video Rules'],
            ['key' => 'ps_judging', 'value' => "Content Quality & Argument Strength|30%\nDelivery (confidence & intonation)|20%\nOrganization & Structure|15%\nLanguage Proficiency (Grammar & Vocabulary)|15%\nPronunciation|15%\nTime Management|5%", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Judging Criteria'],
            ['key' => 'ps_grand_final', 'value' => "Finalists must deliver their speech LIVE (onsite or online) in front of the judges and audience.\nThe duration of the speech is 4–6 minutes.\nNo digital presentation tools, background music, or supporting performers are allowed.\nParticipants must attend the technical meeting; absence may result in disqualification.", 'group' => 'public_speaking', 'type' => 'textarea', 'label' => 'Grand Final Rules'],

            // ============ WORKSHOP ============
            ['key' => 'workshop_title', 'value' => 'Workshop (Provision) & Technical Meeting', 'group' => 'workshop', 'type' => 'text', 'label' => 'Workshop Title'],
            ['key' => 'workshop_subtitle', 'value' => 'May 4, 2026 via Zoom', 'group' => 'workshop', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'workshop_rundown', 'value' => "07:00 – 08:00|15 min|Open Room Zoom & Registrasi Peserta|door_open\n08:00 – 08:05|5 min|Opening Remark & Introduction to the Agenda|mic\n08:05 – 09:20|1h 15min|Workshop Session 1 (Materi + Q&A)|school\n09:20 – 10:35|1h 15min|Workshop Session 2 (Materi + Q&A)|school\n10:35 – 11:35|1 hour|Technical Meeting (Explanation of format submission)|engineering\n11:35 – 11:40|5 min|Closing & Documentation|celebration", 'group' => 'workshop', 'type' => 'textarea', 'label' => 'Workshop Rundown'],
            ['key' => 'workshop_notice', 'value' => 'Attendance to this workshop and technical meeting is mandatory for all registered participants. Absence without prior confirmation may result in disqualification from the competition.', 'group' => 'workshop', 'type' => 'textarea', 'label' => 'Workshop Notice'],

            // ============ RULES PAGE ============
            ['key' => 'rules_hero_image', 'value' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCuvFRlDR1XHdWj2S2qXbsEp40jNUBAcvREy9S7El14AWRhfJBLCgvUwzKJDgjO_g87rd9I92ami9TlfFFlg35AGnfpZ5Ky-LJMaVbLN6JLWq1SpWK3HOE86Ha129Sjw5EKCLSpMIyUkDgy-y9ikIyb7lta8buI5rvMmrmMdqxRRdcp1Tk_6x5c7SZTEAQezYK4Mxy9b65NQh8ScPZC6qE9amklfjNZ3eJ7gkndHUtBzQ7XXjkwZvTqedFMChHbt-fi2sTE28cjKvs', 'group' => 'rules_page', 'type' => 'text', 'label' => 'Rules Hero Image URL'],
            ['key' => 'rules_badge', 'value' => 'RULES & REGULATIONS', 'group' => 'rules_page', 'type' => 'text', 'label' => 'Rules Badge'],
            ['key' => 'rules_title', 'value' => 'The Rules of <br/><span class="text-[#003B73]">Excellence.</span>', 'group' => 'rules_page', 'type' => 'text', 'label' => 'Rules Title'],
            ['key' => 'rules_description', 'value' => 'A curated framework for global thinkers. Ensure your submission aligns with our standards for the 2026 International competition.', 'group' => 'rules_page', 'type' => 'textarea', 'label' => 'Rules Description'],
            ['key' => 'rules_cta_title', 'value' => 'Ready to make your mark?', 'group' => 'rules_page', 'type' => 'text', 'label' => 'CTA Title'],
            ['key' => 'rules_cta_description', 'value' => 'Proceed directly to registration to secure your spot in the 2026 event.', 'group' => 'rules_page', 'type' => 'textarea', 'label' => 'CTA Description'],

            // ============ REGISTRATION PAGES ============
            ['key' => 'reg_nat_hero_image', 'value' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAymwJ4Vb6bJuEXVaoxY4KP6Ni0HKxuF1r8S_fNZwCQXPl58XB9vmA6KPS-ql2naTC_5SY_dx-Jj2f_4mG3WM_PY_NelwfoCqoZ8Nmcj3YBCjHVikSonhgbOBcIRqFnwaxo30-ZKEjV5gc435mcHgQf8pY7kSiPNmHYC_l6DPhUKMQR-u9cGWjp2B8usDKzK6i2y4FzfbwgfCrzGwcQedVH6zyjYq6Rkwhz5nZr7NMsk5vyPJ7F_VtL97mgCKKZiutsmrsRr-yF3TQ', 'group' => 'registration_national', 'type' => 'text', 'label' => 'Hero Image URL'],
            ['key' => 'reg_nat_badge', 'value' => 'HIGH SCHOOL STUDENTS EDITION', 'group' => 'registration_national', 'type' => 'text', 'label' => 'National Badge'],
            ['key' => 'reg_nat_title', 'value' => 'National Competition Registration', 'group' => 'registration_national', 'type' => 'text', 'label' => 'National Title'],
            ['key' => 'reg_nat_description', 'value' => 'Join the most prestigious academic and creative competition. Showcase your talent on a national stage and represent your institution at the Esa Unggul International Event 2026.', 'group' => 'registration_national', 'type' => 'textarea', 'label' => 'National Description'],
            ['key' => 'reg_nat_workshop_label', 'value' => 'Mandatory Zoom Workshop', 'group' => 'registration_national', 'type' => 'text', 'label' => 'Workshop Label'],
            ['key' => 'reg_nat_workshop_datetime', 'value' => 'Sunday, 4 May 2026 • 08:00 AM WIB', 'group' => 'registration_national', 'type' => 'text', 'label' => 'Workshop DateTime'],
            ['key' => 'reg_int_hero_image', 'value' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuASii1uKkJxOKjYWCjbnLLojFSIfdbQOi9NGCOzzF06T3s5In6OzTz5Sg1A2azISLB7zYQ6yUK4GYns_jXlpdcSJG_GRcpykvuZaUv1BVL4nORLA-LwAtKRz8yfIV55X7Qe4yFyb4cKYiqQPsK9uu__UfWk4uSbwxin4w0XptPjXZ02TudVIZj42jM08Fr_YXIYqH8rA3SIJD4bua2WG2IcMr4ku5ow6QLXJlgBF0EiG3DtTFoOm2IpFMoFfs588eBs8idmjI6v1_8', 'group' => 'registration_international', 'type' => 'text', 'label' => 'Hero Image URL'],
            ['key' => 'reg_int_badge', 'value' => 'Registration Open', 'group' => 'registration_international', 'type' => 'text', 'label' => 'International Badge'],
            ['key' => 'reg_int_title', 'value' => 'International Competition Registration', 'group' => 'registration_international', 'type' => 'text', 'label' => 'International Title'],
            ['key' => 'reg_int_description', 'value' => 'Empowering university students globally to showcase their eloquence and cultural narratives through academic excellence.', 'group' => 'registration_international', 'type' => 'textarea', 'label' => 'International Description'],
            ['key' => 'reg_int_entry_fee', 'value' => 'Free', 'group' => 'registration_international', 'type' => 'text', 'label' => 'Entry Fee'],
            ['key' => 'reg_int_workshop_date', 'value' => '4 May 2026', 'group' => 'registration_international', 'type' => 'text', 'label' => 'Workshop Date'],
            ['key' => 'reg_int_note', 'value' => 'Submission signifies commitment to the mandatory Zoom Workshop.', 'group' => 'registration_international', 'type' => 'text', 'label' => 'Important Note'],
        ];

        foreach ($settings as $setting) {
            EventSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
