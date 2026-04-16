@extends('layouts.event')

@section('title', 'International Competition Registration - Esa Unggul International Event 2026')

@section('content')
{{-- Hero Section --}}
<section class="max-w-7xl mx-auto px-6 pt-16 pb-12 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
    <div class="lg:col-span-7">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full mb-6">
            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">stars</span>
            <span class="text-xs font-['Work_Sans'] font-medium uppercase tracking-wider">{{ $settings['reg_int_badge'] ?? 'Registration Open' }}</span>
        </div>
        <h1 class="text-5xl md:text-6xl font-['Plus_Jakarta_Sans'] font-extrabold text-[#141c27] leading-tight mb-6">{{ $settings['reg_int_title'] ?? 'International Competition Registration' }}</h1>
        <p class="text-[#404750] text-lg max-w-xl leading-relaxed font-['Inter']">
            {{ $settings['reg_int_description'] ?? 'Empowering university students globally to showcase their eloquence and cultural narratives through academic excellence.' }}
        </p>
        <div class="mt-8 flex flex-wrap gap-6">
            <div class="flex flex-col gap-1">
                <span class="text-[#404750] font-['Work_Sans'] text-xs uppercase tracking-widest">Entry Fee</span>
                <span class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#8B6914]">{{ $settings['reg_int_entry_fee'] ?? 'Free' }}</span>
            </div>
            <div class="w-px h-12 bg-[#c0c7d2]/30 hidden md:block"></div>
            <div class="flex flex-col gap-1">
                <span class="text-[#404750] font-['Work_Sans'] text-xs uppercase tracking-widest">Mandatory Workshop</span>
                <span class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#003B73]">{{ $settings['reg_int_workshop_date'] ?? '4 May 2026' }}</span>
            </div>
        </div>
    </div>
    <div class="lg:col-span-5 relative">
        <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
            <img class="w-full h-full object-cover" alt="International students" src="{{ $settings['reg_int_hero_image'] ?? '' }}"/>
        </div>
        <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl max-w-[240px]">
            <div class="flex items-center gap-3 mb-2">
                <span class="material-symbols-outlined text-[#003B73]" style="font-variation-settings: 'FILL' 1;">groups</span>
                <span class="font-['Plus_Jakarta_Sans'] font-bold text-sm">Join 500+ Peers</span>
            </div>
            <p class="text-xs text-[#404750] leading-relaxed">Connecting future leaders across more than 20 countries.</p>
        </div>
    </div>
</section>

{{-- Registration Form --}}
<section class="max-w-7xl mx-auto px-6 py-12 pb-24">
    @if(session('success'))
        <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-2xl text-green-800 font-['Inter']">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl text-red-800 font-['Inter']">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#eff4ff] rounded-[2rem] p-8 md:p-16">
        <div class="max-w-4xl mx-auto">
            <form action="{{ route('registration.international.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                @csrf
                <input type="hidden" name="registration_type" value="international">

                {{-- Personal Information --}}
                <div class="md:col-span-2 flex items-center gap-4 mb-2">
                    <h2 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Participant Identity</h2>
                    <div class="h-px flex-grow bg-[#c0c7d2]/20"></div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Full Name</label>
                    <input name="full_name" value="{{ old('full_name') }}" class="w-full bg-white border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] placeholder:text-[#707882] transition-all duration-300" placeholder="As shown on Passport/ID" type="text" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Email Address</label>
                    <input name="email" value="{{ old('email') }}" class="w-full bg-white border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] placeholder:text-[#707882] transition-all duration-300" placeholder="academic@university.edu" type="email" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Whatsapp Number</label>
                    <input name="whatsapp" value="{{ old('whatsapp') }}" class="w-full bg-white border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] placeholder:text-[#707882] transition-all duration-300" placeholder="+1 234 567 890" type="tel" required/>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Institution / University</label>
                    <input name="institution" value="{{ old('institution') }}" class="w-full bg-white border-none rounded-xl py-4 px-6 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] placeholder:text-[#707882] transition-all duration-300" placeholder="Esa Unggul University" type="text" required/>
                </div>

                {{-- Competition Selection --}}
                <div class="md:col-span-2 flex items-center gap-4 mt-6 mb-2">
                    <h2 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Competition Track</h2>
                    <div class="h-px flex-grow bg-[#c0c7d2]/20"></div>
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                    <label class="relative group cursor-pointer">
                        <input class="peer sr-only" name="competition_category_id" type="radio" value="{{ $category->id }}" {{ old('competition_category_id') == $category->id ? 'checked' : '' }} required/>
                        <div class="h-full p-6 bg-white rounded-2xl border-2 border-transparent peer-checked:border-[#003B73] peer-checked:bg-[#cfe5ff]/20 transition-all duration-300 hover:bg-[#e1e9f8]">
                            <div class="w-10 h-10 rounded-xl bg-[#cfe5ff] flex items-center justify-center mb-4 text-[#003B73]">
                                <span class="material-symbols-outlined">{{ $category->icon ?? 'category' }}</span>
                            </div>
                            <h3 class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] mb-1">{{ $category->name }}</h3>
                            <p class="text-xs text-[#404750] leading-relaxed">{{ $category->description }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Document Uploads --}}
                <div class="md:col-span-2 flex items-center gap-4 mt-6 mb-2">
                    <h2 class="text-2xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Verification Documents</h2>
                    <div class="h-px flex-grow bg-[#c0c7d2]/20"></div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Student ID / Passport</label>
                    <div class="relative group">
                        <input class="sr-only" id="id-upload" name="student_id_document" type="file" accept="image/*,.pdf"/>
                        <label class="flex items-center gap-4 w-full bg-white border-2 border-dashed border-[#c0c7d2]/30 rounded-xl py-6 px-6 hover:border-[#0D5DA6] transition-colors cursor-pointer" for="id-upload">
                            <span class="material-symbols-outlined text-[#707882]">upload_file</span>
                            <span class="text-sm text-[#404750] font-medium">Click to upload .pdf or .jpg</span>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">Formal Photo (3x4)</label>
                    <div class="relative group">
                        <input class="sr-only" id="formal-photo-upload" name="formal_photo" type="file" accept="image/*"/>
                        <label class="flex items-center gap-4 w-full bg-white border-2 border-dashed border-[#c0c7d2]/30 rounded-xl py-6 px-6 hover:border-[#0D5DA6] transition-colors cursor-pointer" for="formal-photo-upload">
                            <span class="material-symbols-outlined text-[#707882]">face</span>
                            <span class="text-sm text-[#404750] font-medium">Click to upload .jpg or .png</span>
                        </label>
                    </div>
                </div>

                {{-- YouTube URL --}}
                <div class="md:col-span-2 flex flex-col gap-2">
                    <label class="text-sm font-['Work_Sans'] font-medium text-[#404750] px-1">YouTube Video URL <span class="text-[#404750]/50">(optional)</span></label>
                    <input name="youtube_url" value="{{ old('youtube_url') }}" class="w-full bg-white border-2 border-[#c0c7d2]/30 rounded-xl py-4 px-6 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all placeholder:text-[#707882]" placeholder="https://www.youtube.com/watch?v=..." type="url"/>
                    @error('youtube_url')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit and Note --}}
                <div class="md:col-span-2 bg-[#0D5DA6]/10 p-6 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 mt-10">
                    <div class="flex items-start gap-4">
                        <span class="material-symbols-outlined text-[#003B73] mt-1">info</span>
                        <div>
                            <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] leading-tight">Important Note</p>
                            <p class="text-sm text-[#404750] mt-1">{{ $settings['reg_int_note'] ?? 'Submission signifies commitment to the mandatory Zoom Workshop.' }}</p>
                        </div>
                    </div>
                    <button class="whitespace-nowrap bg-gradient-to-r from-[#003B73] to-[#0D5DA6] text-white px-10 py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg shadow-xl shadow-[#0D5DA6]/20 hover:scale-[1.02] transition-all" type="submit">
                        Submit Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
