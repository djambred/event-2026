@extends('layouts.event')

@section('title', 'Participant Portal - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">
    @if(session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 font-['Inter'] text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600 text-lg">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-12">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-medium mb-6">
            <span class="material-symbols-outlined text-sm">person</span>
            Participant Portal
        </div>
        <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-4xl md:text-5xl text-[#141c27] leading-tight mb-4">
            Welcome, {{ $registration->full_name }}
        </h1>
        <p class="font-['Inter'] text-lg text-[#404750]">
            Here you can view your competition details, scores, and download your certificate.
        </p>
        <form action="{{ route('participant.logout') }}" method="POST" class="mt-4 inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-700 rounded-xl text-sm font-['Plus_Jakarta_Sans'] font-semibold hover:bg-red-100 transition-colors">
                <span class="material-symbols-outlined text-sm">logout</span>
                Logout
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Registration Details --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Status Card --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">assignment</span>
                    Registration Details
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Full Name</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->full_name }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Email</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->email }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Institution</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->institution }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Registration Type</p>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold {{ $registration->registration_type === 'national' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($registration->registration_type) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Competition Category</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->competitionCategory->name }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Status</p>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                            @if($registration->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($registration->status === 'rejected') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            <span class="w-2 h-2 rounded-full
                                @if($registration->status === 'confirmed') bg-green-500
                                @elseif($registration->status === 'rejected') bg-red-500
                                @else bg-yellow-500
                                @endif"></span>
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- YouTube Video Submission --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">play_circle</span>
                    Video Submission
                </h2>
                @if($registration->youtube_url)
                    <div class="mb-4">
                        @php
                            $videoId = null;
                            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $registration->youtube_url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if($videoId)
                            <div class="aspect-video rounded-2xl overflow-hidden">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @else
                            <a href="{{ $registration->youtube_url }}" target="_blank" class="inline-flex items-center gap-2 text-[#003B73] font-semibold hover:underline">
                                <span class="material-symbols-outlined">open_in_new</span>
                                {{ $registration->youtube_url }}
                            </a>
                        @endif
                    </div>
                @endif
                <form action="{{ route('participant.youtube.update') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input name="youtube_url" value="{{ old('youtube_url', $registration->youtube_url) }}" class="flex-1 bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] text-sm" placeholder="https://www.youtube.com/watch?v=..." type="url"/>
                    <button type="submit" class="px-6 py-4 hero-gradient text-white rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-sm hover:scale-[1.02] transition-all active:scale-[0.98]">
                        {{ $registration->youtube_url ? 'Update' : 'Submit' }}
                    </button>
                </form>
                @error('youtube_url')
                    <p class="text-red-500 text-xs mt-2 ml-1">{{ $message }}</p>
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
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">folder_open</span>
                    Uploaded Documents
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($documents as $doc)
                    <div class="border border-[#e1e9f8] rounded-2xl overflow-hidden">
                        <div class="bg-[#eff4ff] px-4 py-3">
                            <p class="font-['Plus_Jakarta_Sans'] font-semibold text-sm text-[#141c27]">{{ $doc['label'] }}</p>
                        </div>
                        @if(in_array(strtolower(pathinfo($doc['file'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <div class="p-4">
                                <img src="{{ asset('storage/' . $doc['file']) }}" alt="{{ $doc['label'] }}" class="w-full rounded-xl object-cover max-h-64"/>
                            </div>
                        @else
                            <div class="p-4 flex items-center gap-3">
                                <span class="material-symbols-outlined text-[#003B73] text-3xl">description</span>
                                <div>
                                    <p class="font-['Inter'] text-sm text-[#404750]">{{ basename($doc['file']) }}</p>
                                    <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank" class="text-[#003B73] text-sm font-semibold hover:underline">View Document</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Judging Criteria --}}
            @if($registration->competitionCategory->judgingCriterias->count() > 0)
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">scale</span>
                    Judging Criteria & Weights
                </h2>
                <div class="space-y-4">
                    @foreach($registration->competitionCategory->judgingCriterias as $criteria)
                    <div class="flex items-center justify-between p-4 bg-[#eff4ff] rounded-xl">
                        <div>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $criteria->name }}</p>
                            @if($criteria->description)
                                <p class="text-sm text-[#404750] mt-1">{{ $criteria->description }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 bg-[#003B73] text-white rounded-full text-sm font-bold">
                                {{ number_format($criteria->weight, 1) }}%
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Scores --}}
            @if($registration->scores->count() > 0)
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">scoreboard</span>
                    Your Scores
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-[#e6eefd]">
                                <th class="text-left py-3 px-4 font-['Plus_Jakarta_Sans'] font-bold text-[#404750] text-sm">Criteria</th>
                                <th class="text-center py-3 px-4 font-['Plus_Jakarta_Sans'] font-bold text-[#404750] text-sm">Weight</th>
                                <th class="text-center py-3 px-4 font-['Plus_Jakarta_Sans'] font-bold text-[#404750] text-sm">Score</th>
                                <th class="text-center py-3 px-4 font-['Plus_Jakarta_Sans'] font-bold text-[#404750] text-sm">Weighted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registration->scores as $score)
                            <tr class="border-b border-[#eff4ff]">
                                <td class="py-3 px-4 font-['Inter'] text-[#141c27]">{{ $score->judgingCriteria->name }}</td>
                                <td class="py-3 px-4 text-center font-['Inter'] text-[#404750]">{{ number_format($score->judgingCriteria->weight, 1) }}%</td>
                                <td class="py-3 px-4 text-center font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ number_format($score->score, 2) }}</td>
                                <td class="py-3 px-4 text-center font-['Plus_Jakarta_Sans'] font-bold text-[#003B73]">{{ number_format($score->score * $score->judgingCriteria->weight / 100, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($registration->final_score !== null)
                <div class="mt-6 p-6 bg-[#003B73] rounded-2xl text-white flex items-center justify-between">
                    <div>
                        <p class="font-['Work_Sans'] text-sm opacity-80">Final Score</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl">{{ number_format($registration->final_score, 2) }}</p>
                    </div>
                    @if($registration->rank)
                    <div class="text-right">
                        <p class="font-['Work_Sans'] text-sm opacity-80">Rank</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl">#{{ $registration->rank }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-8">
            {{-- Quick Info Card --}}
            <div class="bg-[#eff4ff] rounded-3xl p-8 border-2 border-[#0D5DA6]/10">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-[#003B73]">info</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-lg text-[#141c27]">Quick Info</h3>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Registered On</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">WhatsApp</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $registration->whatsapp }}</p>
                    </div>
                </div>
            </div>

            {{-- Certificate Card --}}
            @if($registration->participation_certificate || $registration->winner_certificate || $registration->certificate_file)
            <div class="bg-gradient-to-br from-[#003B73] to-[#0D5DA6] rounded-3xl p-8 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-3xl">workspace_premium</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-lg">Certificates</h3>
                </div>
                <p class="text-white/80 text-sm mb-6">Your certificates are ready for download!</p>
                <div class="space-y-3">
                    @if($registration->participation_certificate || $registration->certificate_file)
                    <a href="{{ route('participant.certificate', ['type' => 'participation']) }}"
                       class="block w-full bg-white text-[#003B73] py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-center hover:scale-[1.02] transition-transform">
                        <span class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">download</span>
                            Participation Certificate
                        </span>
                    </a>
                    @endif
                    @if($registration->winner_certificate)
                    <a href="{{ route('participant.certificate', ['type' => 'winner']) }}"
                       class="block w-full bg-[#E8A317] text-white py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-center hover:scale-[1.02] transition-transform">
                        <span class="flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">emoji_events</span>
                            Winner Certificate
                        </span>
                    </a>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-[#e6eefd] rounded-3xl p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-[#404750] text-3xl">hourglass_empty</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-lg text-[#141c27]">Certificate</h3>
                </div>
                <p class="text-[#404750] text-sm">Your certificate is not yet available. Please check back after the event.</p>
            </div>
            @endif

            {{-- Support Card --}}
            <div class="bg-[#003B73]/5 p-6 rounded-3xl border border-[#003B73]/10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#003B73]/10 flex items-center justify-center text-[#003B73]">
                    <span class="material-symbols-outlined">help</span>
                </div>
                <div>
                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Need help?</p>
                    <a class="text-[#003B73] font-['Work_Sans'] text-sm hover:underline" href="mailto:{{ $settings['contact_email'] ?? 'jefry.sunupurwa@esaunggul.ac.id' }}">Contact support</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
