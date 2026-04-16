@extends('layouts.event')

@section('title', 'Winner Announcements - Esa Unggul International Event 2026')

@section('content')
{{-- Hero Section --}}
<section class="relative py-20 bg-gradient-to-br from-[#003B73] to-[#0D5DA6] overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-[#E8A317]/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-[#E8A317]/20 text-[#FFD993] rounded-full text-xs font-['Work_Sans'] font-medium mb-6">
            <span class="material-symbols-outlined text-sm">emoji_events</span>
            Winner Announcements
        </div>
        <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl md:text-6xl text-white leading-tight mb-4">
            Congratulations to Our <span class="text-[#E8A317]">Winners!</span>
        </h1>
        <p class="font-['Inter'] text-lg text-white/80 max-w-2xl mx-auto">
            Celebrate the outstanding achievements of our talented participants across all competition categories.
        </p>
    </div>
</section>

{{-- Announcements Grid --}}
<section class="py-24 bg-[#f8f9ff]">
    <div class="max-w-7xl mx-auto px-6">
        @if($announcements->isEmpty())
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-[#eff4ff] rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-5xl text-[#003B73]">hourglass_top</span>
                </div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-bold text-2xl text-[#141c27] mb-3">Stay Tuned!</h2>
                <p class="font-['Inter'] text-[#404750] max-w-md mx-auto">
                    Winner announcements will be published here after the judging process is complete. Check back soon!
                </p>
            </div>
        @else
            <div class="space-y-16">
                @foreach($announcements as $announcement)
                    @php $winners = $announcement->getWinners(); @endphp
                    <div class="bg-white rounded-3xl shadow-sm border border-[#e1e9f8] overflow-hidden">
                        {{-- Category Header --}}
                        <div class="bg-gradient-to-r from-[#003B73] to-[#0D5DA6] p-8 md:p-10">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="material-symbols-outlined text-[#E8A317] text-3xl">{{ $announcement->competitionCategory->icon ?? 'emoji_events' }}</span>
                                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl md:text-3xl text-white">
                                    {{ $announcement->competitionCategory->name }}
                                </h2>
                            </div>
                            <p class="font-['Inter'] text-white/80 text-lg">{{ $announcement->title }}</p>
                            @if($announcement->description)
                                <p class="font-['Inter'] text-white/60 mt-2">{{ $announcement->description }}</p>
                            @endif
                        </div>

                        {{-- Winners List --}}
                        <div class="p-8 md:p-10">
                            @if($winners->isNotEmpty())
                                <div class="space-y-6">
                                    @foreach($winners as $winner)
                                        <div class="flex items-center gap-6 {{ $loop->first ? '' : '' }}">
                                            {{-- Rank Badge --}}
                                            <div class="flex-shrink-0">
                                                @if($winner->rank === 1)
                                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#E8A317] to-[#FFD993] flex flex-col items-center justify-center shadow-lg shadow-[#E8A317]/30">
                                                        <span class="material-symbols-outlined text-white text-3xl">trophy</span>
                                                        <span class="text-white font-['Plus_Jakarta_Sans'] font-bold text-xs mt-0.5">1st</span>
                                                    </div>
                                                @elseif($winner->rank === 2)
                                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#9CA3AF] to-[#D1D5DB] flex flex-col items-center justify-center shadow-lg shadow-gray-300/30">
                                                        <span class="material-symbols-outlined text-white text-3xl">military_tech</span>
                                                        <span class="text-white font-['Plus_Jakarta_Sans'] font-bold text-xs mt-0.5">2nd</span>
                                                    </div>
                                                @elseif($winner->rank === 3)
                                                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#CD7F32] to-[#DDA15E] flex flex-col items-center justify-center shadow-lg shadow-orange-300/30">
                                                        <span class="material-symbols-outlined text-white text-3xl">military_tech</span>
                                                        <span class="text-white font-['Plus_Jakarta_Sans'] font-bold text-xs mt-0.5">3rd</span>
                                                    </div>
                                                @else
                                                    <div class="w-20 h-20 rounded-2xl bg-[#eff4ff] flex flex-col items-center justify-center">
                                                        <span class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl text-[#003B73]">{{ $winner->rank }}</span>
                                                        <span class="text-[#0D5DA6] font-['Work_Sans'] text-xs">Place</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Winner Info --}}
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-xl text-[#141c27] truncate">
                                                    {{ $winner->full_name }}
                                                </h3>
                                                <p class="font-['Inter'] text-[#404750]">{{ $winner->institution }}</p>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-['Work_Sans'] font-medium {{ $winner->registration_type === 'national' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                                        {{ ucfirst($winner->registration_type) }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Score --}}
                                            <div class="flex-shrink-0 text-right">
                                                <div class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl text-[#003B73]">
                                                    {{ number_format($winner->final_score, 2) }}
                                                </div>
                                                <div class="text-xs text-[#404750] font-['Work_Sans']">Final Score</div>
                                            </div>
                                        </div>

                                        @if(!$loop->last)
                                            <div class="border-b border-[#e1e9f8]"></div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-[#404750] font-['Inter'] py-8">
                                    Winner details will be updated soon.
                                </p>
                            @endif
                        </div>

                        {{-- Published Date --}}
                        @if($announcement->published_at)
                            <div class="border-t border-[#e1e9f8] px-8 py-4 bg-[#f8f9ff]">
                                <p class="text-sm text-[#404750] font-['Inter']">
                                    <span class="material-symbols-outlined text-sm align-middle mr-1">schedule</span>
                                    Published {{ $announcement->published_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
