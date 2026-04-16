@extends('layouts.event')

@section('title', 'Home - Esa Unggul International Event 2026')

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-[921px] flex items-center overflow-hidden bg-[#f8f9ff] py-20">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-medium mb-6">
                <span class="material-symbols-outlined text-sm">event</span>
                {{ $settings['hero_badge_text'] ?? 'Grand Final: June 10-11, 2026' }}
            </div>
            <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-5xl md:text-7xl text-[#141c27] leading-tight mb-6">
                {!! $settings['hero_title'] ?? 'ESA UNGGUL <span class="text-[#0D5DA6]">INTERNATIONAL</span> EVENT 2026' !!}
            </h1>
            <p class="font-['Inter'] text-xl text-[#404750] max-w-xl mb-10 leading-relaxed">
                {{ $settings['hero_description'] ?? 'Organized by Lembaga Bahasa dan Kebudayaan Universitas Esa Unggul. A global stage for talent, innovation, and academic excellence.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('registration.national') }}" class="hero-gradient text-white px-8 py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg shadow-xl shadow-[#003B73]/20 hover:scale-105 transition-transform text-center">
                    National Registration
                </a>
                <a href="{{ route('registration.international') }}" class="bg-[#dbe3f2] text-[#003B73] px-8 py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg hover:bg-[#e1e9f8] transition-colors text-center">
                    International Registration
                </a>
            </div>
        </div>
        <div class="lg:col-span-5 relative">
            <div class="aspect-square rounded-[2rem] overflow-hidden shadow-2xl relative z-10 rotate-3">
                <img alt="Students celebrating international academic achievement" class="w-full h-full object-cover" src="{{ $settings['hero_image'] ?? '' }}"/>
            </div>
            <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#9acbff] rounded-full blur-3xl opacity-30 -z-10"></div>
            <div class="absolute -bottom-10 -left-10 w-64 h-64 bg-[#FFD993] rounded-full blur-3xl opacity-30 -z-10"></div>
        </div>
    </div>
</section>

{{-- Highlights Bento Grid --}}
<section class="py-24 bg-[#eff4ff]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-16 max-w-2xl">
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl text-[#141c27] mb-4">{{ $settings['highlights_title'] ?? 'A Global Community' }}</h2>
            <p class="font-['Inter'] text-[#404750]">{{ $settings['highlights_description'] ?? 'Bridging excellence across borders. We bring together the brightest minds from across Indonesia and the world.' }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white p-8 rounded-[2rem] flex flex-col justify-between group overflow-hidden relative">
                <div class="relative z-10">
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-3xl mb-4">{{ $settings['national_card_title'] ?? 'National Excellence' }}</h3>
                    <p class="font-['Inter'] text-[#404750] text-lg max-w-md">{{ $settings['national_card_description'] ?? 'Dedicated tracks for Senior High School students across Indonesia to showcase their creative and academic prowess.' }}</p>
                </div>
                <div class="mt-12 flex items-center justify-between relative z-10">
                    <a href="{{ route('registration.national') }}" class="text-[#003B73] font-['Plus_Jakarta_Sans'] font-bold flex items-center gap-2">
                        Learn More <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="bg-[#003B73] text-white p-8 rounded-[2rem] flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">public</span>
                    </div>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-3xl mb-4">{{ $settings['global_card_title'] ?? 'Global Reach' }}</h3>
                    <p class="font-['Inter'] text-white/80">{{ $settings['global_card_description'] ?? 'University students globally are invited to compete on the international stage.' }}</p>
                </div>
                <div class="mt-8">
                    <div class="text-4xl font-['Plus_Jakarta_Sans'] font-black mb-1">{{ $settings['global_card_stat'] ?? '50+' }}</div>
                    <div class="text-white/60 font-['Work_Sans'] uppercase tracking-widest text-xs">{{ $settings['global_card_stat_label'] ?? 'Countries Participating' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories Section --}}
<section class="py-24 bg-[#f8f9ff]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl text-[#141c27] mb-4">{{ $settings['categories_title'] ?? 'Competition Categories' }}</h2>
            <p class="font-['Inter'] text-[#404750] max-w-xl mx-auto">{{ $settings['categories_description'] ?? 'Diverse arenas to challenge your skills and express your creativity.' }}</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($categories as $category)
            <div class="bg-[#eff4ff] p-8 rounded-3xl hover:bg-[#e6eefd] transition-colors group">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-[#003B73] mb-6 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl">{{ $category->icon ?? 'category' }}</span>
                </div>
                <h4 class="font-['Plus_Jakarta_Sans'] font-bold text-xl mb-3">{{ $category->name }}</h4>
                <p class="font-['Inter'] text-[#404750] text-sm leading-relaxed">{{ $category->description }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Important Dates --}}
<section class="py-24 bg-[#dbe3f2]/30">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl text-[#141c27] mb-8">{{ $settings['road_title'] ?? 'Road to Excellence' }}</h2>
                <div class="space-y-8">
                    <div class="flex gap-6 items-start">
                        <div class="bg-[#0D5DA6] text-white w-16 h-16 rounded-2xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-xs font-['Work_Sans']">{{ strtoupper(substr($settings['workshop_date'] ?? 'MAY 04', 0, 3)) }}</span>
                            <span class="text-xl font-['Plus_Jakarta_Sans'] font-bold">{{ substr($settings['workshop_date'] ?? 'MAY 04', -2) }}</span>
                        </div>
                        <div>
                            <h5 class="font-['Plus_Jakarta_Sans'] font-bold text-xl text-[#003B73]">{{ $settings['workshop_label'] ?? 'Zoom Workshop' }}</h5>
                            <p class="font-['Inter'] text-[#404750]">{{ $settings['workshop_description'] ?? 'Intensive technical coaching and briefing session for all registered participants.' }} {{ $settings['workshop_time'] ?? '' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start">
                        <div class="bg-[#8B6914] text-white w-16 h-16 rounded-2xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-xs font-['Work_Sans']">{{ strtoupper(substr($settings['grand_final_day1'] ?? 'JUN 10', 0, 3)) }}</span>
                            <span class="text-xl font-['Plus_Jakarta_Sans'] font-bold">{{ substr($settings['grand_final_day1'] ?? 'JUN 10', -2) }}</span>
                        </div>
                        <div>
                            <h5 class="font-['Plus_Jakarta_Sans'] font-bold text-xl text-[#8B6914]">{{ $settings['final_day1_label'] ?? 'Grand Final Day 1' }}</h5>
                            <p class="font-['Inter'] text-[#404750]">{{ $settings['final_day1_description'] ?? 'Opening ceremony and preliminary rounds of international competitions.' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-6 items-start">
                        <div class="bg-[#8B6914] text-white w-16 h-16 rounded-2xl flex flex-col items-center justify-center shrink-0">
                            <span class="text-xs font-['Work_Sans']">{{ strtoupper(substr($settings['grand_final_day2'] ?? 'JUN 11', 0, 3)) }}</span>
                            <span class="text-xl font-['Plus_Jakarta_Sans'] font-bold">{{ substr($settings['grand_final_day2'] ?? 'JUN 11', -2) }}</span>
                        </div>
                        <div>
                            <h5 class="font-['Plus_Jakarta_Sans'] font-bold text-xl text-[#8B6914]">{{ $settings['final_day2_label'] ?? 'Grand Final & Awards' }}</h5>
                            <p class="font-['Inter'] text-[#404750]">{{ $settings['final_day2_description'] ?? 'The final showcase and prestigious awarding ceremony for all winners.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="rounded-[3rem] overflow-hidden shadow-2xl">
                    <img alt="Event Stage" class="w-full h-[500px] object-cover" src="{{ $settings['road_image'] ?? '' }}"/>
                </div>
                <div class="absolute -bottom-6 right-10 bg-white p-6 rounded-3xl shadow-xl max-w-xs">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="font-['Work_Sans'] font-bold text-sm text-[#141c27]">Registration Active</span>
                    </div>
                    <p class="text-xs text-[#404750] font-['Inter']">Reserve your spot before the deadline.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section id="faq" class="py-24 bg-[#f8f9ff]">

{{-- Winner Announcements Section --}}
@if(isset($announcements) && $announcements->isNotEmpty())
<section id="winners" class="py-24 bg-[#eff4ff]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                <span class="material-symbols-outlined text-sm">emoji_events</span>
                Winner Announcements
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl text-[#141c27] mb-4">Our Champions</h2>
            <p class="font-['Inter'] text-[#404750] max-w-xl mx-auto">Congratulations to all winners! Here are the top performers across all categories.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($announcements as $announcement)
                @php $winners = $announcement->getWinners(); @endphp
                <div class="bg-white rounded-3xl shadow-sm border border-[#e1e9f8] overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="bg-gradient-to-r from-[#003B73] to-[#0D5DA6] p-6">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-[#E8A317]">{{ $announcement->competitionCategory->icon ?? 'emoji_events' }}</span>
                            <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-lg text-white">{{ $announcement->competitionCategory->name }}</h3>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        @foreach($winners->take(3) as $winner)
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center font-bold text-white text-sm {{ $winner->rank === 1 ? 'bg-[#E8A317]' : ($winner->rank === 2 ? 'bg-gray-400' : 'bg-[#CD7F32]') }}">
                                    {{ $winner->rank }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#141c27] truncate">{{ $winner->full_name }}</p>
                                    <p class="font-['Inter'] text-xs text-[#404750] truncate">{{ $winner->institution }}</p>
                                </div>
                                <div class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#003B73]">
                                    {{ number_format($winner->final_score, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('announcements') }}" class="inline-flex items-center gap-2 bg-[#003B73] hover:bg-[#0D5DA6] text-white px-8 py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold transition-colors">
                View All Announcements
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>
    </div>
</section>
@endif

{{-- FAQ Section --}}
<section id="faq" class="py-24 bg-[#f8f9ff]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                <span class="material-symbols-outlined text-sm">help</span>
                FAQ
            </div>
            <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl text-[#141c27] mb-4">Frequently Asked Questions</h2>
            <p class="font-['Inter'] text-[#404750] max-w-xl mx-auto">Everything you need to know about the Esa Unggul International Event 2026.</p>
        </div>
        <div class="space-y-4" x-data="{ open: null }">
            @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-2xl shadow-sm border border-[#e1e9f8] overflow-hidden">
                <button
                    @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                    class="w-full flex items-center justify-between px-8 py-6 text-left transition-colors"
                    :class="open === {{ $index }} ? 'bg-[#eff4ff]' : 'hover:bg-[#f8f9ff]'"
                >
                    <span class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] pr-4">{{ $faq->question }}</span>
                    <span
                        class="material-symbols-outlined text-[#003B73] shrink-0 transition-transform duration-300"
                        :class="open === {{ $index }} ? 'rotate-180' : ''"
                    >expand_more</span>
                </button>
                <div
                    x-show="open === {{ $index }}"
                    x-collapse
                    x-cloak
                >
                    <div class="px-8 pb-6 text-[#404750] font-['Inter'] leading-relaxed prose prose-sm max-w-none">
                        {!! $faq->answer !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
