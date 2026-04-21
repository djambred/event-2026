<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\CompetitionCategory;
use App\Models\EventSetting;
use App\Models\Faq;

class EventController extends Controller
{
    public function home()
    {
        $categories = CompetitionCategory::where('is_active', true)->get();
        $settings = EventSetting::allForFrontend();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $announcements = Announcement::published()
            ->with('competitionCategory')
            ->latest('published_at')
            ->get();

        return view('event.home', compact('categories', 'settings', 'faqs', 'announcements'));
    }

    public function rules()
    {
        $settings = EventSetting::allForFrontend();
        $modernDance = CompetitionCategory::with('judgingCriterias')
            ->where('slug', 'modern-dance')
            ->where('is_active', true)
            ->first();
        $koreanCalligraphy = CompetitionCategory::with('judgingCriterias')
            ->where('slug', 'korean-calligraphy')
            ->where('is_active', true)
            ->first();

        return view('event.rules', compact('settings', 'modernDance', 'koreanCalligraphy'));
    }

    public function announcements()
    {
        $settings = EventSetting::allForFrontend();
        $announcements = Announcement::published()
            ->with('competitionCategory')
            ->latest('published_at')
            ->get();

        return view('event.announcements', compact('settings', 'announcements'));
    }
}
