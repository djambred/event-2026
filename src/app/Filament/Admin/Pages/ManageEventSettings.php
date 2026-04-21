<?php

namespace App\Filament\Admin\Pages;

use App\Models\EventSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageEventSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 0;

    protected static ?string $title = 'Event Settings';

    protected static string $view = 'filament.admin.pages.manage-event-settings';

    public ?array $data = [];

    private const IMAGE_SETTING_KEYS = [
        'hero_image',
        'road_image',
        'reg_nat_hero_image',
        'reg_int_hero_image',
        'rules_hero_image',
    ];

    public function mount(): void
    {
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        foreach (self::IMAGE_SETTING_KEYS as $imageKey) {
            $settings[$imageKey . '_upload'] = null;
        }

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        // ==========================================
                        // GENERAL
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Forms\Components\Section::make('Site Info')->schema([
                                    Forms\Components\TextInput::make('site_title')->label('Site Title'),
                                    Forms\Components\Textarea::make('site_description')->label('Site Description')->rows(3),
                                    Forms\Components\TextInput::make('organizer_name')->label('Organizer Name'),
                                ]),
                                Forms\Components\Section::make('Contact')->schema([
                                    Forms\Components\TextInput::make('contact_email')->label('Contact Email'),
                                    Forms\Components\TextInput::make('contact_phone')->label('Contact Phone'),
                                    Forms\Components\TextInput::make('contact_location')->label('Location'),
                                    Forms\Components\Textarea::make('contact_address')->label('Full Address')->rows(2),
                                    Forms\Components\Textarea::make('footer_description')->label('Footer Description')->rows(3),
                                ]),
                                Forms\Components\Section::make('Payment')->schema([
                                    Forms\Components\TextInput::make('bank_name')->label('Bank Name'),
                                    Forms\Components\TextInput::make('bank_account_number')->label('Account Number'),
                                    Forms\Components\TextInput::make('bank_account_name')->label('Account Name'),
                                ]),
                            ]),

                        // ==========================================
                        // HOME PAGE
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Home Page')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Hero Section')->schema([
                                    Forms\Components\TextInput::make('hero_title')->label('Hero Title (HTML allowed)'),
                                    Forms\Components\TextInput::make('hero_subtitle')->label('Hero Subtitle'),
                                    Forms\Components\Textarea::make('hero_description')->label('Hero Description')->rows(3),
                                    Forms\Components\TextInput::make('hero_badge_text')->label('Badge Text'),
                                    ...$this->imageSettingFields('hero_image', 'Hero Image'),
                                ]),
                                Forms\Components\Section::make('Highlights Section')->schema([
                                    Forms\Components\TextInput::make('highlights_title')->label('Section Title'),
                                    Forms\Components\Textarea::make('highlights_description')->label('Section Description')->rows(2),
                                    Forms\Components\TextInput::make('national_card_title')->label('National Card Title'),
                                    Forms\Components\Textarea::make('national_card_description')->label('National Card Description')->rows(2),
                                    Forms\Components\TextInput::make('global_card_title')->label('Global Card Title'),
                                    Forms\Components\Textarea::make('global_card_description')->label('Global Card Description')->rows(2),
                                    Forms\Components\TextInput::make('global_card_stat')->label('Global Stat (e.g. 50+)'),
                                    Forms\Components\TextInput::make('global_card_stat_label')->label('Stat Label'),
                                ]),
                                Forms\Components\Section::make('Categories Section')->schema([
                                    Forms\Components\TextInput::make('categories_title')->label('Categories Title'),
                                    Forms\Components\Textarea::make('categories_description')->label('Categories Description')->rows(2),
                                ]),
                                Forms\Components\Section::make('Road to Excellence')->schema([
                                    Forms\Components\TextInput::make('road_title')->label('Section Title'),
                                    ...$this->imageSettingFields('road_image', 'Section Image'),
                                    Forms\Components\TextInput::make('workshop_label')->label('Workshop Label'),
                                    Forms\Components\Textarea::make('workshop_description')->label('Workshop Description')->rows(2),
                                    Forms\Components\TextInput::make('final_day1_label')->label('Grand Final Day 1 Label'),
                                    Forms\Components\Textarea::make('final_day1_description')->label('Day 1 Description')->rows(2),
                                    Forms\Components\TextInput::make('final_day2_label')->label('Grand Final Day 2 Label'),
                                    Forms\Components\Textarea::make('final_day2_description')->label('Day 2 Description')->rows(2),
                                ]),
                            ]),

                        // ==========================================
                        // IMPORTANT DATES
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Dates & Timeline')
                            ->icon('heroicon-o-calendar-days')
                            ->schema([
                                Forms\Components\Section::make('Key Dates')->schema([
                                    Forms\Components\TextInput::make('registration_start')->label('Registration Start'),
                                    Forms\Components\TextInput::make('registration_end')->label('Registration End'),
                                    Forms\Components\TextInput::make('workshop_date')->label('Workshop Date'),
                                    Forms\Components\TextInput::make('workshop_time')->label('Workshop Time'),
                                    Forms\Components\TextInput::make('video_submission_start')->label('Video Submission Start'),
                                    Forms\Components\TextInput::make('video_submission_end')->label('Video Submission End'),
                                    Forms\Components\TextInput::make('selection_start')->label('Selection Start'),
                                    Forms\Components\TextInput::make('selection_end')->label('Selection End'),
                                    Forms\Components\TextInput::make('finalist_announcement')->label('Finalist Announcement'),
                                    Forms\Components\TextInput::make('technical_meeting_date')->label('Technical Meeting Date'),
                                    Forms\Components\TextInput::make('technical_meeting_time')->label('Technical Meeting Time'),
                                    Forms\Components\TextInput::make('grand_final_day1')->label('Grand Final Day 1'),
                                    Forms\Components\TextInput::make('grand_final_day2')->label('Grand Final Day 2'),
                                    Forms\Components\TextInput::make('submission_deadline')->label('Submission Deadline Display'),
                                    Forms\Components\Toggle::make('registration_open')->label('Registration Open'),
                                ])->columns(2),
                                Forms\Components\Section::make('Venue')->schema([
                                    Forms\Components\TextInput::make('venue_onsite')->label('Onsite Venue'),
                                    Forms\Components\TextInput::make('venue_online')->label('Online Platform'),
                                ]),
                            ]),

                        // ==========================================
                        // RULES - STORYTELLING (ENGLISH)
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Storytelling (EN)')
                            ->icon('heroicon-o-book-open')
                            ->schema([
                                Forms\Components\Section::make('General Info')->schema([
                                    Forms\Components\TextInput::make('st_en_title')->label('Competition Title'),
                                    Forms\Components\TextInput::make('st_en_category')->label('Category'),
                                    Forms\Components\Textarea::make('st_en_general_info')->label('General Information (one rule per line)')->rows(5)->helperText('Separate each rule with a new line.'),
                                ]),
                                Forms\Components\Section::make('Registration & Zoom')->schema([
                                    Forms\Components\Textarea::make('st_en_registration_rules')->label('Registration Rules (one per line)')->rows(4),
                                    Forms\Components\TextInput::make('st_en_zoom_date')->label('Zoom Session Date & Time'),
                                    Forms\Components\Textarea::make('st_en_zoom_includes')->label('Zoom Session Includes (one per line)')->rows(4),
                                ]),
                                Forms\Components\Section::make('Story Theme')->schema([
                                    Forms\Components\Textarea::make('st_en_theme_rules')->label('Theme Rules (one per line)')->rows(3),
                                ]),
                                Forms\Components\Section::make('Video Submission Rules')->schema([
                                    Forms\Components\TextInput::make('st_en_video_duration')->label('Duration'),
                                    Forms\Components\Textarea::make('st_en_video_rules')->label('Video Rules (one per line)')->rows(15),
                                ]),
                                Forms\Components\Section::make('Judging Criteria')->schema([
                                    Forms\Components\Textarea::make('st_en_judging')->label('Criteria (format: Name|Percentage per line)')->rows(6)->helperText('e.g. Story Mastery & Content Understanding|30%'),
                                ]),
                                Forms\Components\Section::make('Grand Final')->schema([
                                    Forms\Components\Textarea::make('st_en_grand_final')->label('Grand Final Rules (one per line)')->rows(6),
                                ]),
                            ]),

                        // ==========================================
                        // RULES - STORYTELLING (BAHASA)
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Storytelling (ID)')
                            ->icon('heroicon-o-book-open')
                            ->schema([
                                Forms\Components\Section::make('General Info')->schema([
                                    Forms\Components\TextInput::make('st_id_title')->label('Competition Title'),
                                    Forms\Components\TextInput::make('st_id_category')->label('Category'),
                                    Forms\Components\Textarea::make('st_id_general_info')->label('General Provisions (one per line)')->rows(6),
                                ]),
                                Forms\Components\Section::make('Registration & Zoom')->schema([
                                    Forms\Components\Textarea::make('st_id_registration_rules')->label('Registration Rules (one per line)')->rows(4),
                                    Forms\Components\Textarea::make('st_id_registration_uploads')->label('Required Uploads (one per line)')->rows(4),
                                    Forms\Components\TextInput::make('st_id_zoom_date')->label('Zoom Session Date & Time'),
                                    Forms\Components\Textarea::make('st_id_zoom_includes')->label('Zoom Session Includes (one per line)')->rows(4),
                                ]),
                                Forms\Components\Section::make('Story Theme')->schema([
                                    Forms\Components\Textarea::make('st_id_themes')->label('Story Themes (one per line)')->rows(4)->helperText('One theme title per line'),
                                    Forms\Components\Textarea::make('st_id_theme_rules')->label('Theme Rules (one per line)')->rows(3),
                                ]),
                                Forms\Components\Section::make('Video Submission Rules')->schema([
                                    Forms\Components\TextInput::make('st_id_video_duration')->label('Duration'),
                                    Forms\Components\Textarea::make('st_id_video_rules')->label('Video Rules (one per line)')->rows(12),
                                ]),
                                Forms\Components\Section::make('Judging Criteria')->schema([
                                    Forms\Components\Textarea::make('st_id_judging')->label('Criteria (format: Name|Percentage per line)')->rows(6),
                                ]),
                                Forms\Components\Section::make('Grand Final')->schema([
                                    Forms\Components\Textarea::make('st_id_grand_final')->label('Grand Final Rules (one per line)')->rows(6),
                                ]),
                            ]),

                        // ==========================================
                        // RULES - PUBLIC SPEAKING
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Public Speaking')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Forms\Components\Section::make('General Info')->schema([
                                    Forms\Components\TextInput::make('ps_title')->label('Competition Title'),
                                    Forms\Components\TextInput::make('ps_category')->label('Category'),
                                    Forms\Components\Textarea::make('ps_general_info')->label('General Information (one per line)')->rows(5),
                                ]),
                                Forms\Components\Section::make('Registration & Zoom')->schema([
                                    Forms\Components\Textarea::make('ps_registration_rules')->label('Registration Rules (one per line)')->rows(4),
                                    Forms\Components\Textarea::make('ps_registration_uploads')->label('Required Uploads (one per line)')->rows(4),
                                    Forms\Components\TextInput::make('ps_zoom_date')->label('Zoom Session Date & Time'),
                                    Forms\Components\Textarea::make('ps_zoom_includes')->label('Zoom Session Includes (one per line)')->rows(4),
                                ]),
                                Forms\Components\Section::make('Speech Theme')->schema([
                                    Forms\Components\TextInput::make('ps_theme_preliminary')->label('Preliminary Theme'),
                                    Forms\Components\TextInput::make('ps_theme_final')->label('Grand Final Theme'),
                                ]),
                                Forms\Components\Section::make('Video Submission Rules')->schema([
                                    Forms\Components\TextInput::make('ps_video_duration')->label('Duration'),
                                    Forms\Components\Textarea::make('ps_video_rules')->label('Video Rules (one per line)')->rows(12),
                                ]),
                                Forms\Components\Section::make('Judging Criteria')->schema([
                                    Forms\Components\Textarea::make('ps_judging')->label('Criteria (format: Name|Percentage per line)')->rows(8),
                                ]),
                                Forms\Components\Section::make('Grand Final')->schema([
                                    Forms\Components\Textarea::make('ps_grand_final')->label('Grand Final Rules (one per line)')->rows(6),
                                ]),
                            ]),

                        // ==========================================
                        // WORKSHOP RUNDOWN
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Workshop')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Section::make('Workshop Rundown')->schema([
                                    Forms\Components\TextInput::make('workshop_title')->label('Workshop Title'),
                                    Forms\Components\TextInput::make('workshop_subtitle')->label('Subtitle'),
                                    Forms\Components\Textarea::make('workshop_rundown')->label('Rundown (format: Time|Duration|Agenda|Icon per line)')->rows(10)->helperText('e.g. 07:00 – 08:00|15 min|Open Room Zoom & Registration|door_open'),
                                    Forms\Components\Textarea::make('workshop_notice')->label('Important Notice')->rows(3),
                                ]),
                            ]),

                        // ==========================================
                        // REGISTRATION PAGES
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Registration Pages')
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Forms\Components\Section::make('National Registration Page')->schema([
                                    Forms\Components\TextInput::make('reg_nat_badge')->label('Badge Text'),
                                    Forms\Components\TextInput::make('reg_nat_title')->label('Page Title'),
                                    Forms\Components\Textarea::make('reg_nat_description')->label('Description')->rows(3),
                                    Forms\Components\TextInput::make('reg_nat_workshop_label')->label('Workshop Label'),
                                    Forms\Components\TextInput::make('reg_nat_workshop_datetime')->label('Workshop Date & Time'),
                                    ...$this->imageSettingFields('reg_nat_hero_image', 'Hero Image'),
                                ]),
                                Forms\Components\Section::make('International Registration Page')->schema([
                                    Forms\Components\TextInput::make('reg_int_badge')->label('Badge Text'),
                                    Forms\Components\TextInput::make('reg_int_title')->label('Page Title'),
                                    Forms\Components\Textarea::make('reg_int_description')->label('Description')->rows(3),
                                    Forms\Components\TextInput::make('reg_int_entry_fee')->label('Entry Fee Label'),
                                    Forms\Components\TextInput::make('reg_int_workshop_date')->label('Workshop Date Display'),
                                    Forms\Components\TextInput::make('reg_int_note')->label('Important Note Text'),
                                    ...$this->imageSettingFields('reg_int_hero_image', 'Hero Image'),
                                ]),
                            ]),

                        // ==========================================
                        // RULES PAGE GENERAL
                        // ==========================================
                        Forms\Components\Tabs\Tab::make('Rules Page')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('Rules Hero Section')->schema([
                                    Forms\Components\TextInput::make('rules_badge')->label('Badge Text'),
                                    Forms\Components\TextInput::make('rules_title')->label('Page Title (HTML allowed)'),
                                    Forms\Components\Textarea::make('rules_description')->label('Description')->rows(3),
                                    ...$this->imageSettingFields('rules_hero_image', 'Hero Image'),
                                ]),
                                Forms\Components\Section::make('CTA Section')->schema([
                                    Forms\Components\TextInput::make('rules_cta_title')->label('CTA Title'),
                                    Forms\Components\Textarea::make('rules_cta_description')->label('CTA Description')->rows(2),
                                ]),
                            ]),
                    ])->columnSpanFull()->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (self::IMAGE_SETTING_KEYS as $imageKey) {
            $uploadKey = $imageKey . '_upload';

            if (!empty($data[$uploadKey])) {
                $data[$imageKey] = $data[$uploadKey];
            }

            unset($data[$uploadKey]);
        }

        foreach ($data as $key => $value) {
            EventSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'label' => str_replace('_', ' ', ucfirst($key)),
                    'group' => $this->getGroupForKey($key),
                ]
            );
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    private function getGroupForKey(string $key): string
    {
        return match (true) {
            str_starts_with($key, 'hero_') || str_starts_with($key, 'highlights_') || str_starts_with($key, 'national_card_') || str_starts_with($key, 'global_card_') || str_starts_with($key, 'categories_') || str_starts_with($key, 'road_') || str_starts_with($key, 'final_day') || str_starts_with($key, 'workshop_label') || str_starts_with($key, 'workshop_desc') => 'home',
            str_starts_with($key, 'st_en_') => 'storytelling_en',
            str_starts_with($key, 'st_id_') => 'storytelling_id',
            str_starts_with($key, 'ps_') => 'public_speaking',
            str_starts_with($key, 'workshop_') => 'workshop',
            str_starts_with($key, 'rules_') => 'rules_page',
            str_starts_with($key, 'reg_nat_') => 'registration_national',
            str_starts_with($key, 'reg_int_') => 'registration_international',
            str_starts_with($key, 'bank_') || str_starts_with($key, 'payment_') => 'payment',
            str_starts_with($key, 'contact_') || str_starts_with($key, 'footer_') => 'contact',
            str_starts_with($key, 'registration_') || str_starts_with($key, 'submission_') || str_starts_with($key, 'video_') || str_starts_with($key, 'selection_') || str_starts_with($key, 'finalist_') || str_starts_with($key, 'technical_') || str_starts_with($key, 'grand_final') || str_starts_with($key, 'venue_') => 'dates',
            default => 'general',
        };
    }

    private function imageSettingFields(string $settingKey, string $label): array
    {
        return [
            Forms\Components\FileUpload::make($settingKey . '_upload')
                ->label($label . ' Upload')
                ->image()
                ->disk('public')
                ->directory('event-settings')
                ->visibility('public')
                ->imageEditor()
                ->helperText('Upload gambar baru untuk menggantikan URL yang sedang dipakai.'),
            Forms\Components\TextInput::make($settingKey)
                ->label($label . ' URL')
                ->url()
                ->suffixIcon('heroicon-o-photo'),
        ];
    }
}
