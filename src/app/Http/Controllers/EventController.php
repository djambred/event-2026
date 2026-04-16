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
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        $announcements = Announcement::published()
            ->with('competitionCategory')
            ->latest('published_at')
            ->get();

        return view('event.home', compact('categories', 'settings', 'faqs', 'announcements'));
    }

    public function rules()
    {
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        return view('event.rules', compact('settings'));
    }

    public function announcements()
    {
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $announcements = Announcement::published()
            ->with('competitionCategory')
            ->latest('published_at')
            ->get();

        return view('event.announcements', compact('settings', 'announcements'));
    }
}
