@extends('layouts.event')

@section('title', 'Participant Portal - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-800 font-['Inter'] text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600 text-base">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Compact Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full hero-gradient flex items-center justify-center text-white font-['Plus_Jakarta_Sans'] font-extrabold text-lg">
                {{ strtoupper(substr($registration->full_name, 0, 1)) }}
            </div>
            <div>
                <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl text-[#141c27] leading-tight">{{ $registration->full_name }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $registration->registration_type === 'national' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($registration->registration_type) }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                        @if($registration->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($registration->status === 'rejected') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($registration->status) }}
                    </span>
                    @if($registration->stage !== 'selection')
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                        @if($registration->stage === 'finalist') bg-green-100 text-green-800
                        @elseif($registration->stage === 'grandfinal') bg-amber-100 text-amber-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($registration->stage === 'finalist') Finalist
                        @elseif($registration->stage === 'grandfinal') Grand Final
                        @else Eliminated @endif
                    </span>
                    @endif
                    <span class="text-[#404750] text-xs font-['Inter']">{{ $registration->competitionCategory->name }}</span>
                </div>
            </div>
        </div>
        <form action="{{ route('participant.logout') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-xs font-['Plus_Jakarta_Sans'] font-semibold hover:bg-red-100 transition-colors">
                <span class="material-symbols-outlined text-sm">logout</span>
                Logout
            </button>
        </form>
    </div>

    {{-- Stage Announcement Banner --}}
    @if($registration->stage === 'finalist')
    <div class="mb-5 relative overflow-hidden bg-gradient-to-r from-green-600 to-emerald-500 rounded-2xl p-5 text-white shadow-lg">
        <div class="absolute -right-6 -top-6 w-28 h-28 bg-white/10 rounded-full"></div>
        <div class="absolute -right-2 -bottom-8 w-20 h-20 bg-white/5 rounded-full"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">emoji_events</span>
            </div>
            <div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-lg leading-tight">Selamat! Anda Lolos ke Grand Final 🎉</h2>
                <p class="font-['Inter'] text-sm text-white/85 mt-1">Anda berhasil melewati tahap seleksi dan terpilih sebagai finalis. Bersiaplah untuk babak Grand Final!</p>
                @if($registration->final_score && $registration->rank)
                <p class="font-['Work_Sans'] text-xs text-white/70 mt-2">Skor Seleksi: <strong class="text-white">{{ floatval($registration->final_score) }}</strong> · Peringkat: <strong class="text-white">#{{ $registration->rank }}</strong></p>
                @endif
            </div>
        </div>
    </div>
    @elseif($registration->stage === 'grandfinal')
    <div class="mb-5 relative overflow-hidden bg-gradient-to-r from-amber-500 to-yellow-500 rounded-2xl p-5 text-white shadow-lg">
        <div class="absolute -right-6 -top-6 w-28 h-28 bg-white/10 rounded-full"></div>
        <div class="absolute -right-2 -bottom-8 w-20 h-20 bg-white/5 rounded-full"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">stars</span>
            </div>
            <div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-lg leading-tight">Babak Grand Final Sedang Berlangsung 🏆</h2>
                <p class="font-['Inter'] text-sm text-white/85 mt-1">Anda sedang mengikuti babak Grand Final. Tunjukkan performa terbaik Anda!</p>
            </div>
        </div>
    </div>
    @elseif($registration->stage === 'eliminated')
    <div class="mb-5 relative overflow-hidden bg-gradient-to-r from-slate-600 to-slate-500 rounded-2xl p-5 text-white shadow-lg">
        <div class="absolute -right-6 -top-6 w-28 h-28 bg-white/10 rounded-full"></div>
        <div class="absolute -right-2 -bottom-8 w-20 h-20 bg-white/5 rounded-full"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">sentiment_neutral</span>
            </div>
            <div>
                <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-lg leading-tight">Terima Kasih Atas Partisipasi Anda</h2>
                <p class="font-['Inter'] text-sm text-white/85 mt-1">Mohon maaf, Anda belum berhasil lolos ke tahap Grand Final pada kesempatan ini. Tetap semangat dan jangan menyerah!</p>
                @if($registration->final_score && $registration->rank)
                <p class="font-['Work_Sans'] text-xs text-white/70 mt-2">Skor Seleksi: <strong class="text-white">{{ floatval($registration->final_score) }}</strong> · Peringkat: <strong class="text-white">#{{ $registration->rank }}</strong></p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-7 space-y-5">
            {{-- Registration Details --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">assignment</span>
                    Registration Details
                </h2>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider">Email</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27] truncate">{{ $registration->email }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider">WhatsApp</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">{{ $registration->whatsapp }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider">Institution</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">{{ $registration->institution }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider">Registered</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">{{ $registration->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Video Submission --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">play_circle</span>
                    Video Submission
                </h2>
                @if($registration->youtube_url)
                    @php
                        $videoId = null;
                        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $registration->youtube_url, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <div class="aspect-video rounded-xl overflow-hidden mb-3">
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    @endif
                @endif
                <form action="{{ route('participant.youtube.update') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input name="youtube_url" value="{{ old('youtube_url', $registration->youtube_url) }}" class="flex-1 bg-[#eff4ff] border-none rounded-lg p-3 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] text-xs" placeholder="https://www.youtube.com/watch?v=..." type="url"/>
                    <button type="submit" class="px-4 py-3 hero-gradient text-white rounded-lg font-['Plus_Jakarta_Sans'] font-bold text-xs hover:scale-[1.02] transition-all active:scale-[0.98]">
                        {{ $registration->youtube_url ? 'Update' : 'Submit' }}
                    </button>
                </form>
                @error('youtube_url')
                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Uploaded Documents --}}
            @php
                $documents = collect([
                    ['label' => 'School Uniform Photo', 'file' => $registration->school_uniform_photo],
                    ['label' => 'Proof of Payment', 'file' => $registration->payment_proof],
                    ['label' => 'Student ID / Passport', 'file' => $registration->student_id_document],
                    ['label' => 'Formal Photo (3x4)', 'file' => $registration->formal_photo],
                ])->filter(fn ($doc) => $doc['file']);
            @endphp

            @if($documents->isNotEmpty())
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">folder_open</span>
                    Documents
                </h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($documents as $doc)
                    <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-[#eff4ff] rounded-lg hover:bg-[#e1e9f8] transition-colors text-sm">
                        <span class="material-symbols-outlined text-[#003B73] text-base">
                            @if(in_array(strtolower(pathinfo($doc['file'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                image
                            @else
                                description
                            @endif
                        </span>
                        <span class="font-['Plus_Jakarta_Sans'] font-semibold text-xs text-[#141c27]">{{ $doc['label'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: Scores + Sidebar --}}
        <div class="lg:col-span-5 space-y-5">
            {{-- Scores --}}
            @if($registration->scores->count() > 0)
            @php
                $selectionScores = $registration->scores->where('round', 'selection');
                $grandfinalScores = $registration->scores->where('round', 'grandfinal');
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">scoreboard</span>
                    Scores
                </h2>

                {{-- Selection Round --}}
                @if($selectionScores->count() > 0)
                <div class="mb-3">
                    <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider mb-2">Seleksi</p>
                    <div class="space-y-1.5">
                        @foreach($selectionScores as $score)
                        <div class="flex items-center justify-between py-1.5 px-3 bg-[#f8f9ff] rounded-lg">
                            <span class="font-['Inter'] text-xs text-[#141c27]">{{ $score->judgingCriteria->name }}</span>
                            <div class="flex items-center gap-3">
                                <span class="font-['Inter'] text-[10px] text-[#404750]">{{ floatval($score->judgingCriteria->weight) }}%</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-xs text-[#003B73] w-8 text-right">{{ floatval($score->score) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($registration->final_score !== null)
                <div class="p-4 bg-[#003B73] rounded-xl text-white flex items-center justify-between mb-3">
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] opacity-80 uppercase">Final Score</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl">{{ floatval($registration->final_score) }}</p>
                    </div>
                    @if($registration->rank)
                    <div class="text-right">
                        <p class="font-['Work_Sans'] text-[10px] opacity-80 uppercase">Rank</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl">#{{ $registration->rank }}</p>
                    </div>
                    @endif
                </div>
                @endif
                @endif

                {{-- Grand Final Round --}}
                @if($grandfinalScores->count() > 0)
                <div class="mb-3">
                    <p class="font-['Work_Sans'] text-[10px] text-amber-700 uppercase tracking-wider mb-2">Grand Final</p>
                    <div class="space-y-1.5">
                        @foreach($grandfinalScores as $score)
                        <div class="flex items-center justify-between py-1.5 px-3 bg-amber-50 rounded-lg">
                            <span class="font-['Inter'] text-xs text-[#141c27]">{{ $score->judgingCriteria->name }}</span>
                            <div class="flex items-center gap-3">
                                <span class="font-['Inter'] text-[10px] text-[#404750]">{{ floatval($score->judgingCriteria->weight) }}%</span>
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-xs text-amber-700 w-8 text-right">{{ floatval($score->score) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($registration->grandfinal_score !== null)
                <div class="p-4 bg-gradient-to-r from-amber-500 to-amber-600 rounded-xl text-white flex items-center justify-between">
                    <div>
                        <p class="font-['Work_Sans'] text-[10px] opacity-80 uppercase">GF Score</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl">{{ floatval($registration->grandfinal_score) }}</p>
                    </div>
                    @if($registration->grandfinal_rank)
                    <div class="text-right">
                        <p class="font-['Work_Sans'] text-[10px] opacity-80 uppercase">GF Rank</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl">#{{ $registration->grandfinal_rank }}</p>
                    </div>
                    @endif
                </div>
                @endif
                @endif
            </div>
            @elseif($registration->competitionCategory->judgingCriterias->count() > 0)
            {{-- Show criteria if no scores yet --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">scale</span>
                    Judging Criteria
                </h2>
                <div class="space-y-1.5">
                    @foreach($registration->competitionCategory->judgingCriterias as $criteria)
                    <div class="flex items-center justify-between py-2 px-3 bg-[#f8f9ff] rounded-lg">
                        <span class="font-['Inter'] text-xs text-[#141c27]">{{ $criteria->name }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 bg-[#003B73] text-white rounded-full text-[10px] font-bold">
                            {{ floatval($criteria->weight) }}%
                        </span>
                    </div>
                    @endforeach
                </div>
                <p class="text-[10px] text-[#404750] mt-3 font-['Inter']">Scores will appear here after judging.</p>
            </div>
            @endif

            {{-- Announcements --}}
            @if($announcements->count() > 0)
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">campaign</span>
                    Pengumuman
                </h2>
                <div class="space-y-3">
                    @foreach($announcements as $announcement)
                    <div class="rounded-xl border {{ $announcement->type === 'zoom' ? 'border-blue-200 bg-blue-50' : ($announcement->type === 'winner' ? 'border-amber-200 bg-amber-50' : 'border-[#e1e9f8] bg-[#f8f9ff]') }} p-3">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base mt-0.5 {{ $announcement->type === 'zoom' ? 'text-blue-600' : ($announcement->type === 'winner' ? 'text-amber-600' : 'text-[#003B73]') }}">
                                @if($announcement->type === 'zoom') videocam
                                @elseif($announcement->type === 'winner') emoji_events
                                @else info @endif
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="font-['Plus_Jakarta_Sans'] font-bold text-xs text-[#141c27]">{{ $announcement->title }}</p>
                                @if($announcement->description)
                                <p class="font-['Inter'] text-[11px] text-[#404750] mt-1">{{ $announcement->description }}</p>
                                @endif
                                @if($announcement->type === 'zoom' && $announcement->zoom_url)
                                <a href="{{ $announcement->zoom_url }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 mt-2 px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-['Plus_Jakarta_Sans'] font-bold hover:bg-blue-700 transition-colors">
                                    <span class="material-symbols-outlined text-sm">videocam</span>
                                    Join Zoom Meeting
                                </a>
                                @endif
                                <p class="font-['Inter'] text-[10px] text-[#404750]/60 mt-1.5">{{ $announcement->published_at?->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Certificate Card --}}
            @if($hasParticipationCert || $hasWinnerCert)
            <div class="bg-gradient-to-br from-[#003B73] to-[#0D5DA6] rounded-2xl p-5 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-xl">workspace_premium</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-sm">Certificates</h3>
                </div>
                <div class="space-y-2">
                    @if($hasParticipationCert)
                    <a href="{{ route('participant.certificate', ['type' => 'participation']) }}"
                       class="block w-full bg-white text-[#003B73] py-2.5 rounded-lg font-['Plus_Jakarta_Sans'] font-bold text-xs text-center hover:scale-[1.02] transition-transform">
                        <span class="flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-base">download</span>
                            Participation Certificate
                        </span>
                    </a>
                    @endif
                    @if($hasWinnerCert)
                    <a href="{{ route('participant.certificate', ['type' => 'winner']) }}"
                       class="block w-full bg-[#E8A317] text-white py-2.5 rounded-lg font-['Plus_Jakarta_Sans'] font-bold text-xs text-center hover:scale-[1.02] transition-transform">
                        <span class="flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-base">emoji_events</span>
                            Winner Certificate
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-[#e6eefd] rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-[#404750] text-xl">hourglass_empty</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#141c27]">Certificate</h3>
                </div>
                <p class="text-[#404750] text-xs">Not yet available. Check back after the event.</p>
            </div>
            @endif

            {{-- Contact Support --}}
            <div class="bg-[#003B73]/5 p-4 rounded-2xl border border-[#003B73]/10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#003B73]/10 flex items-center justify-center text-[#003B73] shrink-0">
                    <span class="material-symbols-outlined text-lg">help</span>
                </div>
                <div>
                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-xs">Need help?</p>
                    <a class="text-[#003B73] font-['Work_Sans'] text-xs hover:underline" href="mailto:{{ $settings['contact_email'] ?? 'jefry.sunupurwa@esaunggul.ac.id' }}">Contact support</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
