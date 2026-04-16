@extends('layouts.event')

@section('title', 'Rules & Regulations - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
{{-- Hero Section --}}
<header class="max-w-7xl mx-auto px-6 py-12 md:py-20 mb-12">
    <div class="flex flex-col md:flex-row gap-12 items-start">
        <div class="md:w-3/5">
            <span class="inline-block px-4 py-1.5 rounded-full bg-[#FFF0C8] text-[#3D2B00] font-['Work_Sans'] text-xs font-bold tracking-wider mb-6">{{ $settings['rules_badge'] ?? 'RULES & REGULATIONS' }}</span>
            <h1 class="text-5xl md:text-7xl font-['Plus_Jakarta_Sans'] font-extrabold tracking-tight text-[#141c27] leading-tight mb-8">
                {!! $settings['rules_title'] ?? 'The Rules of <br/><span class="text-[#003B73]">Excellence.</span>' !!}
            </h1>
            <p class="text-lg md:text-xl text-[#404750] leading-relaxed max-w-2xl">
                {{ $settings['rules_description'] ?? 'A curated framework for global thinkers. Ensure your submission aligns with our standards for the 2026 International competition.' }}
            </p>
        </div>
        <div class="md:w-2/5 relative hidden md:block">
            <div class="aspect-square rounded-full overflow-hidden bg-[#e6eefd] shadow-2xl">
                <img alt="Professional seminar hall" class="w-full h-full object-cover" src="{{ $settings['rules_hero_image'] ?? '' }}"/>
            </div>
        </div>
    </div>
</header>

{{-- Competition Rules Tabs --}}
<div class="max-w-7xl mx-auto px-6 pb-24" x-data="{ activeTab: 'storytelling-en' }">

    {{-- Tab Navigation --}}
    <div class="flex flex-wrap gap-3 mb-10">
        <button @click="activeTab = 'storytelling-en'"
            :class="activeTab === 'storytelling-en' ? 'bg-[#003B73] text-white shadow-lg shadow-[#003B73]/20' : 'bg-[#eff4ff] text-[#003B73] hover:bg-[#e6eefd]'"
            class="px-6 py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-sm transition-all duration-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">auto_stories</span>
            Storytelling (English)
        </button>
        <button @click="activeTab = 'storytelling-id'"
            :class="activeTab === 'storytelling-id' ? 'bg-[#003B73] text-white shadow-lg shadow-[#003B73]/20' : 'bg-[#eff4ff] text-[#003B73] hover:bg-[#e6eefd]'"
            class="px-6 py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-sm transition-all duration-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">auto_stories</span>
            Storytelling (Bahasa)
        </button>
        <button @click="activeTab = 'public-speaking'"
            :class="activeTab === 'public-speaking' ? 'bg-[#003B73] text-white shadow-lg shadow-[#003B73]/20' : 'bg-[#eff4ff] text-[#003B73] hover:bg-[#e6eefd]'"
            class="px-6 py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-sm transition-all duration-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">campaign</span>
            Public Speaking (English)
        </button>
        <button @click="activeTab = 'workshop'"
            :class="activeTab === 'workshop' ? 'bg-[#8B6914] text-white shadow-lg shadow-[#8B6914]/20' : 'bg-[#FFF0C8] text-[#3D2B00] hover:bg-[#ffd0b8]'"
            class="px-6 py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-sm transition-all duration-200 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">schedule</span>
            Workshop Rundown
        </button>
    </div>

    {{-- ============================================== --}}
    {{-- TAB 1: STORYTELLING COMPETITION (ENGLISH) --}}
    {{-- ============================================== --}}
    <div x-show="activeTab === 'storytelling-en'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        {{-- Title Banner --}}
        <div class="bg-gradient-to-r from-[#003B73] to-[#0D5DA6] rounded-3xl p-8 md:p-12 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                    <span class="material-symbols-outlined text-sm">public</span>
                    INTERNATIONAL COMPETITION
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl mb-2">{{ $settings['st_en_title'] ?? 'Storytelling Competition (English)' }}</h2>
                <p class="text-white/80 text-lg font-['Inter']">Category: {{ $settings['st_en_category'] ?? 'University Students' }}</p>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-10">
                <span class="material-symbols-outlined" style="font-size: 14rem;">auto_stories</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- General Information --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">info</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">General Information</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_en_general_info'] ?? "The competition is open to active university students.\nParticipants must ensure that all submitted registration data is accurate and valid.\nBy registering, participants agree to comply with all rules and regulations.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Registration --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">app_registration</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Registration</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_en_registration_rules'] ?? "Registration must be completed through the registration link provided by the committee.\nThe participants must upload a student ID card and a formal photograph.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Zoom Session --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10 border-l-4 border-[#8B6914]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Zoom Session (Mandatory)</h3>
                    </div>
                    <div class="bg-white rounded-2xl p-6 mb-4">
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#8B6914] text-lg mb-1">{{ $settings['st_en_zoom_date'] ?? 'May 4, 2026 at 08:00 AM (Jakarta\'s time)' }}</p>
                        <p class="text-[#404750] text-sm font-['Inter']">All registered participants must attend this Zoom session.</p>
                    </div>
                    <p class="text-[#404750] font-['Inter'] mb-3">The session includes:</p>
                    <ul class="space-y-2 text-[#404750] font-['Inter'] ml-4">
                        @foreach(explode("\n", $settings['st_en_zoom_includes'] ?? "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official storytelling theme\nQuestion & Answer session") as $item)
                            @if(trim($item)) <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#003B73] text-lg">check_circle</span> {{ trim($item) }}</li> @endif
                        @endforeach
                    </ul>
                    <div class="mt-4 p-3 bg-red-50 rounded-xl text-red-700 text-sm font-['Inter'] flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg mt-0.5">warning</span>
                        Absence without prior confirmation may result in disqualification.
                    </div>
                </section>

                {{-- Competition Format --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">trophy</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Competition Format</h3>
                    </div>
                    <p class="text-[#404750] font-['Inter'] mb-4">The competition consists of two stages:</p>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-[#eff4ff] p-6 rounded-2xl">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-8 h-8 rounded-full bg-[#003B73] text-white flex items-center justify-center text-xs font-bold">1</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Preliminary Round</span>
                            </div>
                            <p class="text-sm text-[#404750]">Video Submission</p>
                        </div>
                        <div class="bg-[#eff4ff] p-6 rounded-2xl">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-8 h-8 rounded-full bg-[#8B6914] text-white flex items-center justify-center text-xs font-bold">2</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Grand Final</span>
                            </div>
                            <p class="text-sm text-[#404750]">Live Performance</p>
                        </div>
                    </div>
                </section>

                {{-- Story Theme --}}
                <section class="bg-[#e6eefd] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Story Theme</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_en_theme_rules'] ?? "Participants must choose one original folktale from their country of origin.\nThe story must be delivered in English.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Video Submission Rules --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Preliminary Round – Video Submission Rules</h3>
                    </div>
                    <ol class="space-y-4 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_en_video_rules'] ?? "The participants must join the provision session on Zoom Meeting.\nThe storytelling performance must be delivered fully in English.\nDuration: Minimum 3 minutes – Maximum 5 minutes.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Grand Final Rules --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Grand Final Rules</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#8B6914]">
                        @foreach(explode("\n", $settings['st_en_grand_final'] ?? "Finalists must perform LIVE in front of the judges and audience.\nThe story must be the same as the one submitted in the preliminary round.\nThe duration of the performance is 3–5 minutes.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                @include('event.partials.judging-criteria', ['judgingData' => $settings['st_en_judging'] ?? "Story Mastery & Content Understanding|30%\nPronunciation & Intonation|20%\nFacial Expression & Body Language|20%\nCreativity & Use of Props|20%\nTime Management|10%"])
                @include('event.partials.timeline-sidebar', ['settings' => $settings])
            </div>
        </div>
    </div>

    {{-- ============================================== --}}
    {{-- TAB 2: STORYTELLING COMPETITION (BAHASA INDONESIA) --}}
    {{-- ============================================== --}}
    <div x-show="activeTab === 'storytelling-id'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        {{-- Title Banner --}}
        <div class="bg-gradient-to-r from-[#003B73] to-[#0D5DA6] rounded-3xl p-8 md:p-12 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                    <span class="material-symbols-outlined text-sm">public</span>
                    INTERNATIONAL COMPETITION
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl mb-2">{{ $settings['st_id_title'] ?? 'Storytelling Competition (Bahasa Indonesia)' }}</h2>
                <p class="text-white/80 text-lg font-['Inter']">Category: {{ $settings['st_id_category'] ?? 'Foreign University Students' }}</p>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-10">
                <span class="material-symbols-outlined" style="font-size: 14rem;">auto_stories</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                {{-- General Provisions --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">info</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">General Provisions</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_id_general_info'] ?? "The competition is open to active foreign university students.\nParticipants must ensure all submitted data is accurate.\nBy registering, participants agree to comply with all rules.\nJudges' decisions are final.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Registration --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">app_registration</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Registration</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_id_registration_rules'] ?? "Registration must be completed through the official registration link.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                    @if(!empty($settings['st_id_registration_uploads']))
                    <div class="mt-4">
                        <p class="text-[#404750] font-['Inter'] mb-2">Participants must upload:</p>
                        <ul class="space-y-1 ml-4">
                            @foreach(explode("\n", $settings['st_id_registration_uploads']) as $upload)
                                @if(trim($upload)) <li class="flex items-center gap-2 text-[#404750] font-['Inter']"><span class="material-symbols-outlined text-[#003B73] text-lg">upload_file</span> {{ trim($upload) }}</li> @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </section>

                {{-- Zoom Session --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10 border-l-4 border-[#8B6914]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Zoom Session (Mandatory)</h3>
                    </div>
                    <div class="bg-white rounded-2xl p-6 mb-4">
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#8B6914] text-lg mb-1">{{ $settings['st_id_zoom_date'] ?? 'May 4, 2026 at 08:00 AM (Jakarta\'s time)' }}</p>
                    </div>
                    <ul class="space-y-2 text-[#404750] font-['Inter'] ml-4">
                        @foreach(explode("\n", $settings['st_id_zoom_includes'] ?? "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official storytelling theme\nQuestion & Answer session") as $item)
                            @if(trim($item)) <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#003B73] text-lg">check_circle</span> {{ trim($item) }}</li> @endif
                        @endforeach
                    </ul>
                    <div class="mt-4 p-3 bg-red-50 rounded-xl text-red-700 text-sm font-['Inter'] flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg mt-0.5">warning</span>
                        Absence without prior confirmation may result in disqualification.
                    </div>
                </section>

                {{-- Story Theme --}}
                <section class="bg-[#e6eefd] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Story Theme</h3>
                    </div>
                    @if(!empty($settings['st_id_themes']))
                    <p class="text-[#404750] font-['Inter'] mb-4">The story themes are:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                        @foreach(explode("\n", $settings['st_id_themes']) as $theme)
                            @if(trim($theme))
                            <div class="bg-white p-4 rounded-xl text-center">
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73] text-lg">{{ trim($theme) }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                    <ol class="space-y-3 text-[#404750] font-['Inter']">
                        @foreach(explode("\n", $settings['st_id_theme_rules'] ?? "Participants must create an original storytelling performance related to Indonesian culture.\nThe story must be delivered fully in Bahasa Indonesia.") as $i => $rule)
                            @if(trim($rule)) <li class="flex gap-2"><span class="font-bold text-[#003B73]">{{ $i + 2 }}.</span> {{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Video Submission Rules --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Preliminary Round – Video Submission Rules</h3>
                    </div>
                    <ol class="space-y-4 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['st_id_video_rules'] ?? "Duration: Minimum 4 minutes – Maximum 7 minutes.\nVideo quality must be at least 720p (HD).\nThe video must be recorded in one continuous take.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Grand Final Rules --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Grand Final Rules</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#8B6914]">
                        @foreach(explode("\n", $settings['st_id_grand_final'] ?? "Finalists must perform LIVE in front of the judges and audience.\nThe story must be the same as the one submitted in the preliminary round.\nThe duration of the performance is 3–5 minutes.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                @include('event.partials.judging-criteria', ['judgingData' => $settings['st_id_judging'] ?? "Story Mastery & Content Understanding|30%\nPronunciation & Intonation|20%\nFacial Expression & Body Language|20%\nCreativity & Use of Props|20%\nTime Management|10%"])
                @include('event.partials.timeline-sidebar', ['settings' => $settings])
            </div>
        </div>
    </div>

    {{-- ============================================== --}}
    {{-- TAB 3: PUBLIC SPEAKING COMPETITION (ENGLISH) --}}
    {{-- ============================================== --}}
    <div x-show="activeTab === 'public-speaking'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        {{-- Title Banner --}}
        <div class="bg-gradient-to-r from-[#003B73] to-[#0D5DA6] rounded-3xl p-8 md:p-12 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                    <span class="material-symbols-outlined text-sm">public</span>
                    INTERNATIONAL COMPETITION
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl mb-2">{{ $settings['ps_title'] ?? 'Public Speaking Competition (English)' }}</h2>
                <p class="text-white/80 text-lg font-['Inter']">Category: {{ $settings['ps_category'] ?? 'University Students' }}</p>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-10">
                <span class="material-symbols-outlined" style="font-size: 14rem;">campaign</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                {{-- General Information --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">info</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">General Information</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['ps_general_info'] ?? "The competition is open to active university students.\nParticipants must ensure all registration data is accurate.\nBy registering, participants agree to comply with all rules.\nJudges' decisions are final.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>

                {{-- Registration --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">app_registration</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Registration</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#003B73]">
                        @foreach(explode("\n", $settings['ps_registration_rules'] ?? "Registration must be completed through the official registration link.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                    @if(!empty($settings['ps_registration_uploads']))
                    <div class="mt-4">
                        <p class="text-[#404750] font-['Inter'] mb-2">Participants must upload:</p>
                        <ul class="space-y-1 ml-4">
                            @foreach(explode("\n", $settings['ps_registration_uploads']) as $upload)
                                @if(trim($upload)) <li class="flex items-center gap-2 text-[#404750] font-['Inter']"><span class="material-symbols-outlined text-[#003B73] text-lg">upload_file</span> {{ trim($upload) }}</li> @endif
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </section>

                {{-- Zoom Session --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10 border-l-4 border-[#8B6914]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Zoom Session (Mandatory)</h3>
                    </div>
                    <div class="bg-white rounded-2xl p-6 mb-4">
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#8B6914] text-lg mb-1">{{ $settings['ps_zoom_date'] ?? 'May 4, 2026 at 08:00 AM (Jakarta\'s time)' }}</p>
                    </div>
                    <ul class="space-y-2 text-[#404750] font-['Inter'] ml-4">
                        @foreach(explode("\n", $settings['ps_zoom_includes'] ?? "Pre Event Workshop\nThe Provision Session\nAnnouncement of the official speech theme\nQuestion & Answer session") as $item)
                            @if(trim($item)) <li class="flex items-center gap-2"><span class="material-symbols-outlined text-[#003B73] text-lg">check_circle</span> {{ trim($item) }}</li> @endif
                        @endforeach
                    </ul>
                    <div class="mt-4 p-3 bg-red-50 rounded-xl text-red-700 text-sm font-['Inter'] flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg mt-0.5">warning</span>
                        Absence without prior confirmation may result in disqualification.
                    </div>
                </section>

                {{-- Speech Theme --}}
                <section class="bg-[#e6eefd] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">lightbulb</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Speech Theme</h3>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div class="bg-white p-6 rounded-2xl">
                            <p class="font-['Work_Sans'] text-xs uppercase tracking-wider text-[#404750] mb-2">Preliminary Round</p>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73] text-lg leading-tight">{{ $settings['ps_theme_preliminary'] ?? 'AI as a Partner, Not a Threat: New Perspective' }}</p>
                        </div>
                        <div class="bg-white p-6 rounded-2xl">
                            <p class="font-['Work_Sans'] text-xs uppercase tracking-wider text-[#404750] mb-2">Grand Final</p>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#8B6914] text-lg leading-tight">{{ $settings['ps_theme_final'] ?? 'Why the Future Needs Human Creativity Alongside AI' }}</p>
                        </div>
                    </div>
                    <p class="text-[#404750] font-['Inter']">The speech must be delivered fully in <strong class="text-[#141c27]">English</strong>.</p>
                </section>

                {{-- Video Submission Rules --}}
                <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-[#e6eefd]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-[#eff4ff] flex items-center justify-center text-[#003B73]">
                            <span class="material-symbols-outlined">videocam</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Preliminary Round – Video Submission Rules</h3>
                    </div>
                    <ul class="space-y-4 text-[#404750] font-['Inter']">
                        @foreach(explode("\n", $settings['ps_video_rules'] ?? "Duration: Minimum 4 minutes – Maximum 6 minutes.\nVideo quality must be at least 720p (HD).\nThe video must be recorded in one continuous take.") as $rule)
                            @if(trim($rule))
                            <li class="flex gap-3 items-start">
                                <span class="material-symbols-outlined text-[#003B73] shrink-0 mt-0.5">check</span>
                                <span>{{ trim($rule) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </section>

                {{-- Grand Final Rules --}}
                <section class="bg-[#eff4ff] rounded-3xl p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#8B6914]">
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <h3 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Grand Final Rules</h3>
                    </div>
                    <ol class="space-y-3 text-[#404750] font-['Inter'] list-decimal list-inside marker:font-bold marker:text-[#8B6914]">
                        @foreach(explode("\n", $settings['ps_grand_final'] ?? "Finalists must deliver their speech LIVE in front of the judges and audience.\nThe duration of the speech is 4–6 minutes.\nNo digital presentation tools, background music, or supporting performers are allowed.") as $rule)
                            @if(trim($rule)) <li>{{ trim($rule) }}</li> @endif
                        @endforeach
                    </ol>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">
                @include('event.partials.judging-criteria', ['judgingData' => $settings['ps_judging'] ?? "Content Quality & Argument Strength|30%\nDelivery (confidence & intonation)|20%\nOrganization & Structure|15%\nLanguage Proficiency|15%\nPronunciation|15%\nTime Management|5%"])
                @include('event.partials.timeline-sidebar', ['settings' => $settings])
            </div>
        </div>
    </div>

    {{-- ============================================== --}}
    {{-- TAB 4: WORKSHOP RUNDOWN --}}
    {{-- ============================================== --}}
    <div x-show="activeTab === 'workshop'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        {{-- Title Banner --}}
        <div class="bg-gradient-to-r from-[#8B6914] to-[#E8A317] rounded-3xl p-8 md:p-12 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    MANDATORY SESSION
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl mb-2">{{ $settings['workshop_title'] ?? 'Workshop (Provision) & Technical Meeting' }}</h2>
                <p class="text-white/80 text-lg font-['Inter']">{{ $settings['workshop_subtitle'] ?? 'May 4, 2026 via Zoom' }}</p>
            </div>
            <div class="absolute -bottom-10 -right-10 opacity-10">
                <span class="material-symbols-outlined" style="font-size: 14rem;">schedule</span>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-3xl shadow-sm border border-[#e6eefd] overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#003B73] text-white">
                            <th class="px-6 py-4 text-left font-['Plus_Jakarta_Sans'] font-bold text-sm">Time (WIB)</th>
                            <th class="px-6 py-4 text-left font-['Plus_Jakarta_Sans'] font-bold text-sm">Duration</th>
                            <th class="px-6 py-4 text-left font-['Plus_Jakarta_Sans'] font-bold text-sm">Agenda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e6eefd]">
                        @foreach(explode("\n", $settings['workshop_rundown'] ?? "07:00 – 08:00|15 min|Open Room Zoom & Registration|door_open\n08:00 – 08:05|5 min|Opening Remark|mic\n08:05 – 09:20|1h 15min|Workshop Session 1|school\n09:20 – 10:35|1h 15min|Workshop Session 2|school\n10:35 – 11:35|1 hour|Technical Meeting|engineering\n11:35 – 11:40|5 min|Closing & Documentation|celebration") as $row)
                            @php $cols = explode('|', trim($row)); @endphp
                            @if(count($cols) >= 3)
                            <tr class="hover:bg-[#eff4ff] transition-colors">
                                <td class="px-6 py-5 font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ trim($cols[0]) }}</td>
                                <td class="px-6 py-5 text-[#404750] font-['Inter']">{{ trim($cols[1]) }}</td>
                                <td class="px-6 py-5 font-['Inter']">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[#003B73]">{{ isset($cols[3]) ? trim($cols[3]) : 'event' }}</span>
                                        <span class="text-[#141c27] font-medium">{{ trim($cols[2]) }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 p-6 bg-red-50 rounded-2xl text-red-700 font-['Inter'] flex items-start gap-3">
                <span class="material-symbols-outlined text-2xl mt-0.5">warning</span>
                <div>
                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-lg mb-1">Important Notice</p>
                    <p class="text-sm">{{ $settings['workshop_notice'] ?? 'Attendance to this workshop and technical meeting is mandatory for all registered participants. Absence without prior confirmation may result in disqualification from the competition.' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact & CTA --}}
    <div class="mt-20 grid grid-cols-1 md:grid-cols-12 gap-6">
        {{-- Contact Info --}}
        <section class="md:col-span-5 bg-[#e1e9f8] rounded-3xl p-8 md:p-10 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold mb-2">Need Clarification?</h2>
                <p class="text-[#404750] mb-8">Our academic committee is here to assist with any technical or administrative inquiries.</p>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl">
                        <span class="material-symbols-outlined text-[#003B73]">alternate_email</span>
                        <span class="font-['Inter'] font-medium text-[#141c27]">{{ $settings['contact_email'] ?? 'lbk@esaunggul.ac.id' }}</span>
                    </div>
                    <div class="flex items-center gap-3 p-4 bg-white rounded-xl">
                        <span class="material-symbols-outlined text-[#003B73]">location_on</span>
                        <span class="font-['Inter'] font-medium text-[#141c27]">{{ $settings['contact_address'] ?? 'Gedung A, R.416-417, Lantai 4, Jl. Arjuna Utara No.9, Kebon Jeruk, Jakarta 11510' }}</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="md:col-span-7 editorial-gradient rounded-3xl p-8 md:p-12 text-white flex flex-col justify-center">
            <h2 class="text-3xl md:text-4xl font-['Plus_Jakarta_Sans'] font-extrabold mb-4">{{ $settings['rules_cta_title'] ?? 'Ready to make your mark?' }}</h2>
            <p class="text-lg opacity-90 mb-8 max-w-lg">{{ $settings['rules_cta_description'] ?? 'Proceed directly to registration to secure your spot in the 2026 event.' }}</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('registration.national') }}" class="bg-white text-[#003B73] px-8 py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg hover:scale-105 transition-transform text-center">
                    National Registration
                </a>
                <a href="{{ route('registration.international') }}" class="bg-[#0D5DA6] text-white px-8 py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg hover:scale-105 transition-transform border border-white/20 text-center">
                    International Registration
                </a>
            </div>
        </section>
    </div>
</div>
@endsection
