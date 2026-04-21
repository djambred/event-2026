@extends('layouts.event')

@section('title', 'Participant Portal - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
{{-- Register Key Toast --}}
@if(session('register_key'))
<div x-data="{ show: true, copied: false }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 text-center" @click.outside="show = false">
        <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-green-600 text-3xl">check_circle</span>
        </div>
        <h2 class="font-['Plus_Jakarta_Sans'] font-extrabold text-2xl text-[#141c27] mb-2">Registrasi Berhasil!</h2>
        <p class="font-['Inter'] text-[#404750] text-sm mb-6">Simpan <strong>Register Key</strong> berikut untuk login ke portal. Pastikan kamu menyimpannya di tempat yang aman.</p>
        <div class="relative bg-[#eff4ff] rounded-xl p-4 mb-4 flex items-center justify-between gap-3">
            <span id="register-key-text" class="font-mono font-bold text-xl text-[#003B73] tracking-wider select-all">{{ session('register_key') }}</span>
            <button type="button" @click="navigator.clipboard.writeText('{{ session('register_key') }}'); copied = true; setTimeout(() => copied = false, 2000)" class="flex-shrink-0 inline-flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-semibold transition-all" :class="copied ? 'bg-green-500 text-white' : 'bg-[#003B73] text-white hover:bg-[#0D5DA6]'">
                <span x-show="!copied" class="material-symbols-outlined text-base">content_copy</span>
                <span x-show="!copied">Copy</span>
                <span x-show="copied" class="material-symbols-outlined text-base">done</span>
                <span x-show="copied">Copied!</span>
            </button>
        </div>
        <p class="text-xs text-red-500 font-semibold mb-6">
            <span class="material-symbols-outlined text-xs align-middle">warning</span>
            Register Key ini tidak akan ditampilkan lagi setelah ditutup!
        </p>
        <button @click="show = false" class="w-full hero-gradient text-white py-3 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-base shadow-lg hover:scale-[1.02] transition-all active:scale-[0.98]">
            Saya Sudah Menyimpan, Lanjutkan
        </button>
    </div>
</div>
@endif

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
            <div class="bg-white rounded-2xl p-5 shadow-sm"
                 x-data="{ open: false, src: '', label: '', isImage: false }"
                 @keydown.escape.window="open = false">

                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">folder_open</span>
                    Documents
                </h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($documents as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc['file'], PATHINFO_EXTENSION));
                        $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $fileUrl = asset('storage/' . $doc['file']);
                    @endphp
                    <button type="button"
                        @click="src = '{{ $fileUrl }}'; label = '{{ $doc['label'] }}'; isImage = {{ $isImg ? 'true' : 'false' }}; open = true"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-[#eff4ff] rounded-lg hover:bg-[#e1e9f8] transition-colors text-sm cursor-pointer">
                        <span class="material-symbols-outlined text-[#003B73] text-base">
                            {{ $isImg ? 'image' : 'description' }}
                        </span>
                        <span class="font-['Plus_Jakarta_Sans'] font-semibold text-xs text-[#141c27]">{{ $doc['label'] }}</span>
                        <span class="material-symbols-outlined text-[#003B73]/50 text-sm">visibility</span>
                    </button>
                    @endforeach
                </div>

                {{-- Preview Modal --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
                     @click.self="open = false"
                     style="display: none;">
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

                        {{-- Modal Header --}}
                        <div class="flex items-center justify-between px-5 py-4 border-b border-[#e1e9f8]">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#003B73] text-lg" x-text="isImage ? 'image' : 'description'"></span>
                                <span class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#141c27]" x-text="label"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a :href="src" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#eff4ff] text-[#003B73] rounded-lg text-xs font-['Plus_Jakarta_Sans'] font-semibold hover:bg-[#e1e9f8] transition-colors">
                                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                                    Buka
                                </a>
                                <button @click="open = false"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-[#404750] hover:text-red-600 transition-colors">
                                    <span class="material-symbols-outlined text-base">close</span>
                                </button>
                            </div>
                        </div>

                        {{-- Modal Body --}}
                        <div class="flex-1 overflow-auto p-4 bg-[#f8f9ff] flex items-center justify-center min-h-0">
                            <template x-if="isImage">
                                <img :src="src" :alt="label"
                                     class="max-w-full max-h-[65vh] rounded-xl object-contain shadow-md" />
                            </template>
                            <template x-if="!isImage">
                                <iframe :src="src" class="w-full rounded-xl shadow-md bg-white" style="height: 65vh;" frameborder="0"></iframe>
                            </template>
                        </div>
                    </div>
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
                $selectionGrouped = $selectionScores->groupBy('judging_criteria_id');
                $grandfinalGrouped = $grandfinalScores->groupBy('judging_criteria_id');

                // Bangun label "Juri 1", "Juri 2", dst — urutkan berdasarkan ID user agar konsisten
                $juryLabelMap = $registration->competitionCategory->judges
                    ->sortBy('id')
                    ->values()
                    ->mapWithKeys(fn ($judge, $index) => [$judge->id => 'Juri ' . ($index + 1)])
                    ->toArray();
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-base font-bold mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#003B73] text-lg">scoreboard</span>
                    Scores
                </h2>

                <div class="mb-3 p-3 bg-[#eff4ff] rounded-xl">
                    <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider">Jumlah Juri per Kategori</p>
                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-sm text-[#141c27]">{{ $expectedJudgeCount }} Juri</p>
                    <div class="mt-2 grid grid-cols-2 gap-2 text-[11px]">
                        <div class="bg-white rounded-lg px-2 py-1.5">
                            <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase">Penilaian Seleksi</p>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73]">{{ $selectionJudgeCount }}/{{ $expectedJudgeCount }}</p>
                        </div>
                        <div class="bg-white rounded-lg px-2 py-1.5">
                            <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase">Penilaian Grand Final</p>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-amber-700">{{ $grandfinalJudgeCount }}/{{ $expectedJudgeCount }}</p>
                        </div>
                    </div>
                </div>

                {{-- Selection Round --}}
                @if($selectionScores->count() > 0)
                <div class="mb-3">
                    <p class="font-['Work_Sans'] text-[10px] text-[#404750] uppercase tracking-wider mb-2">Seleksi</p>
                    <div class="space-y-1.5">
                        @foreach($selectionGrouped as $criteriaScores)
                        @php
                            $criteria = $criteriaScores->first()?->judgingCriteria;
                            $avgScore = round($criteriaScores->avg('score'), 2);
                        @endphp
                        @if($criteria)
                        <div class="py-2 px-3 bg-[#f8f9ff] rounded-lg">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-['Inter'] text-xs text-[#141c27]">{{ $criteria->name }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="font-['Inter'] text-[10px] text-[#404750]">{{ floatval($criteria->weight) }}%</span>
                                    <span class="font-['Plus_Jakarta_Sans'] font-bold text-xs text-[#003B73]">Avg {{ $avgScore }}</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                @foreach($criteriaScores as $judgeScore)
                                <div class="flex items-center justify-between text-[11px] text-[#404750]">
                                    <span class="truncate">{{ $juryLabelMap[$judgeScore->scored_by] ?? 'Juri' }}</span>
                                    <span class="font-['Plus_Jakarta_Sans'] font-semibold text-[#003B73]">{{ floatval($judgeScore->score) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
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
                        @foreach($grandfinalGrouped as $criteriaScores)
                        @php
                            $criteria = $criteriaScores->first()?->judgingCriteria;
                            $avgScore = round($criteriaScores->avg('score'), 2);
                        @endphp
                        @if($criteria)
                        <div class="py-2 px-3 bg-amber-50 rounded-lg">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="font-['Inter'] text-xs text-[#141c27]">{{ $criteria->name }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="font-['Inter'] text-[10px] text-[#404750]">{{ floatval($criteria->weight) }}%</span>
                                    <span class="font-['Plus_Jakarta_Sans'] font-bold text-xs text-amber-700">Avg {{ $avgScore }}</span>
                                </div>
                            </div>
                            <div class="space-y-1">
                                @foreach($criteriaScores as $judgeScore)
                                <div class="flex items-center justify-between text-[11px] text-[#404750]">
                                    <span class="truncate">{{ $juryLabelMap[$judgeScore->scored_by] ?? 'Juri' }}</span>
                                    <span class="font-['Plus_Jakarta_Sans'] font-semibold text-amber-700">{{ floatval($judgeScore->score) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
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
            @if($hasParticipationCert)
            <div class="bg-gradient-to-br from-[#003B73] to-[#0D5DA6] rounded-2xl p-5 text-white">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-xl">workspace_premium</span>
                    <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-sm">Certificates</h3>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('participant.certificate', ['type' => 'participation']) }}"
                       class="block w-full bg-white text-[#003B73] py-2.5 rounded-lg font-['Plus_Jakarta_Sans'] font-bold text-xs text-center hover:scale-[1.02] transition-transform">
                        <span class="flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-base">download</span>
                            Participation Certificate
                        </span>
                    </a>
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
