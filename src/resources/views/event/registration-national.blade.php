@extends('layouts.event')

@section('title', 'National Competition Registration - Esa Unggul International Event 2026')

@section('content')
{{-- Hero Section --}}
<section class="max-w-7xl mx-auto px-6 pt-16 pb-12 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
    <div class="lg:col-span-7">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-bold mb-6">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">stars</span>
            {{ $settings['reg_nat_badge'] ?? 'HIGH SCHOOL STUDENTS EDITION' }}
        </div>
        <h1 class="font-['Plus_Jakarta_Sans'] text-5xl md:text-6xl font-extrabold text-[#141c27] leading-tight mb-6">
            {{ $settings['reg_nat_title'] ?? 'National Competition Registration' }}
        </h1>
        <p class="text-[#404750] text-lg max-w-2xl leading-relaxed mb-8">
            {{ $settings['reg_nat_description'] ?? 'Join the most prestigious academic and creative competition. Showcase your talent on a national stage and represent your institution at the Esa Unggul International Event 2026.' }}
        </p>
        <div class="flex items-center gap-6 p-6 bg-[#eff4ff] rounded-xl border-l-4 border-[#8B6914]">
            <div class="flex-shrink-0 bg-[#E8A317] p-3 rounded-xl text-white">
                <span class="material-symbols-outlined text-3xl">event_upcoming</span>
            </div>
            <div>
                <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-lg">{{ $settings['reg_nat_workshop_label'] ?? 'Mandatory Zoom Workshop' }}</p>
                <p class="text-[#404750]">{{ $settings['reg_nat_workshop_datetime'] ?? 'Sunday, 4 May 2026 • 08:00 AM WIB' }}</p>
            </div>
        </div>
    </div>
    <div class="lg:col-span-5 relative hidden lg:block">
        <div class="aspect-square rounded-[3rem] overflow-hidden bg-[#e6eefd] rotate-3 shadow-xl">
            <img alt="Students participating in a national academic competition" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700" src="{{ $settings['reg_nat_hero_image'] ?? '' }}"/>
        </div>
        <div class="absolute -bottom-6 -left-6 bg-white p-8 rounded-3xl shadow-2xl max-w-[200px] -rotate-3">
            <p class="font-['Plus_Jakarta_Sans'] font-black text-4xl text-[#003B73] mb-1">2026</p>
            <p class="font-['Work_Sans'] text-sm uppercase tracking-widest text-[#404750]">Global Reach</p>
        </div>
    </div>
</section>

{{-- Registration Form --}}
<section class="max-w-7xl mx-auto px-6 pb-24">
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

    <form action="{{ route('registration.national.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        <input type="hidden" name="registration_type" value="national">

        {{-- Left Column: Personal Information --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">person</span>
                    Personal Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Full Name</label>
                        <input name="full_name" value="{{ old('full_name') }}" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="As shown in Student ID" type="text" required/>
                    </div>
                    <div class="space-y-2">
                        <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Whatsapp Number</label>
                        <input name="whatsapp" value="{{ old('whatsapp') }}" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="08xx atau +628xx" type="tel" required/>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Email Address</label>
                        <input name="email" value="{{ old('email') }}" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="student@school.edu" type="email" required/>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Institution / School Name</label>
                        <input name="institution" value="{{ old('institution') }}" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="e.g. SMAN 1 Jakarta" type="text" required/>
                    </div>
                </div>
                <div class="mt-8" x-data="{ fileName: '' }">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] block mb-4 ml-1">School Uniform Photo</label>
                    <div :class="fileName ? 'border-green-500 bg-green-50' : 'border-[#c0c7d2] bg-[#f8f9ff] hover:bg-[#eff4ff]'" class="border-2 border-dashed rounded-2xl p-8 text-center transition-colors group cursor-pointer">
                        <input class="hidden" id="photo-upload" name="school_uniform_photo" type="file" accept="image/*,.pdf" @change="fileName = $event.target.files[0]?.name || ''"/>
                        <label class="cursor-pointer flex flex-col items-center" for="photo-upload">
                            <span x-show="!fileName" class="material-symbols-outlined text-4xl text-[#707882] mb-2 group-hover:text-[#003B73] transition-colors">upload_file</span>
                            <span x-show="fileName" class="material-symbols-outlined text-4xl text-green-600 mb-2">check_circle</span>
                            <p x-show="!fileName" class="font-['Inter'] text-sm text-[#404750]"><span class="text-[#003B73] font-bold">Click to upload</span> or drag and drop</p>
                            <p x-show="fileName" class="font-['Inter'] text-sm text-green-700 font-semibold" x-text="fileName"></p>
                            <p x-show="!fileName" class="font-['Work_Sans'] text-xs text-[#707882] mt-1">JPG, PNG or PDF (Max. 5MB)</p>
                            <p x-show="fileName" class="font-['Work_Sans'] text-xs text-green-600 mt-1">Click to change file</p>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Competition Category Selection --}}
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm">
                <h2 class="font-['Plus_Jakarta_Sans'] text-2xl font-bold mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">category</span>
                    Competition Categories
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($categories as $category)
                    <label class="relative flex flex-col p-6 rounded-2xl bg-[#eff4ff] cursor-pointer hover:bg-[#e6eefd] transition-colors border-2 border-transparent has-[:checked]:border-[#003B73] has-[:checked]:bg-[#003B73]/5">
                        <input class="absolute top-4 right-4 text-[#003B73] focus:ring-[#0D5DA6]" name="competition_category_id" type="radio" value="{{ $category->id }}" {{ old('competition_category_id') == $category->id ? 'checked' : '' }} required/>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full bg-[#003B73]/10 flex items-center justify-center text-[#003B73]">
                                <span class="material-symbols-outlined">{{ $category->icon ?? 'category' }}</span>
                            </div>
                            <div>
                                <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] leading-tight">{{ $category->name }}</p>
                                <p class="font-['Work_Sans'] text-xs text-[#404750]">{{ ucfirst($category->type) }}</p>
                            </div>
                        </div>
                        <div class="mt-auto">
                            <p class="text-xl font-['Plus_Jakarta_Sans'] font-black text-[#8B6914]">{{ $category->formatted_price_national }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right Column: Payment Details --}}
        <div class="space-y-8">
            <div class="bg-[#eff4ff] p-8 rounded-3xl sticky top-28 border-2 border-[#0D5DA6]/10">
                <h2 class="font-['Plus_Jakarta_Sans'] text-xl font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#003B73]">payments</span>
                    Payment Details
                </h2>
                <div class="bg-white p-6 rounded-xl space-y-4 mb-8">
                    <div class="flex justify-between items-center pb-4 border-b border-[#e6eefd]">
                        <span class="font-['Work_Sans'] text-sm text-[#404750]">Bank Transfer</span>
                        <span class="font-['Plus_Jakarta_Sans'] font-bold text-[#003B73]">{{ $settings['bank_name'] ?? 'BNI' }}</span>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Account Number</p>
                        <div class="flex items-center justify-between">
                            <p class="font-['Plus_Jakarta_Sans'] text-2xl font-black text-[#141c27]">{{ $settings['bank_account_number'] ?? '0218392241' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="font-['Work_Sans'] text-xs text-[#404750] uppercase tracking-wider mb-1">Account Name</p>
                        <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">{{ $settings['bank_account_name'] ?? 'Universitas Esa Unggul' }}</p>
                    </div>
                </div>
                <div class="space-y-2 mb-8">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Proof of Payment</label>
                    <div class="relative group" x-data="{ fileName: '' }">
                        <div :class="fileName ? 'border-green-500 bg-green-50' : 'bg-[#dbe3f2] border-[#c0c7d2] group-hover:border-[#003B73]'" class="w-full h-32 border-2 border-dashed rounded-xl flex flex-col items-center justify-center transition-all">
                            <span x-show="!fileName" class="material-symbols-outlined text-3xl text-[#707882] group-hover:text-[#003B73] mb-2">receipt_long</span>
                            <span x-show="fileName" class="material-symbols-outlined text-3xl text-green-600 mb-2">check_circle</span>
                            <p x-show="!fileName" class="text-xs font-['Work_Sans'] text-[#404750]">Upload Receipt</p>
                            <p x-show="fileName" class="text-xs font-['Work_Sans'] text-green-700 font-semibold px-4 text-center truncate max-w-full" x-text="fileName"></p>
                            <p x-show="fileName" class="text-xs font-['Work_Sans'] text-green-600 mt-1">Click to change</p>
                            <input name="payment_proof" class="absolute inset-0 opacity-0 cursor-pointer" type="file" accept="image/*,.pdf" @change="fileName = $event.target.files[0]?.name || ''"/>
                        </div>
                    </div>
                </div>

                {{-- YouTube URL --}}
                <div class="space-y-2">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">YouTube Video URL <span class="text-[#404750]/50 font-normal">(optional)</span></label>
                    <input name="youtube_url" value="{{ old('youtube_url') }}" class="w-full bg-[#dbe3f2] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#003B73] text-[#141c27] transition-all placeholder:text-[#707882]" placeholder="https://www.youtube.com/watch?v=..." type="url"/>
                    @error('youtube_url')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Captcha --}}
                <div class="space-y-2 mt-6 mb-8">
                    <div class="flex items-center justify-between">
                        <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Security Check: What is <span id="captcha-question" class="font-mono font-bold text-[#003B73]">{{ $captcha_question }}</span> ?</label>
                        <button type="button" id="captcha-refresh-btn" class="inline-flex items-center gap-1 text-xs font-['Work_Sans'] font-semibold text-[#003B73] hover:text-[#0D5DA6] transition-colors">
                            <span class="material-symbols-outlined text-base">refresh</span>
                            Refresh
                        </button>
                    </div>
                    <input name="captcha_answer" id="captcha-input" class="w-full bg-[#dbe3f2] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#003B73] text-[#141c27] transition-all placeholder:text-[#707882]" placeholder="Enter the answer" type="number" required/>
                    <input type="hidden" name="captcha_token" id="captcha-token" value="{{ $captcha_token }}"/>
                    @error('captcha_answer')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full form-gradient text-white py-5 rounded-2xl font-['Plus_Jakarta_Sans'] font-extrabold text-lg shadow-xl shadow-[#003B73]/20 hover:scale-[1.02] transition-all active:scale-[0.98]" type="submit">
                    Complete Registration
                </button>
                <p class="text-center text-xs text-[#404750] mt-6 px-4">
                    By clicking register, you agree to our Terms of Service and competition rules.
                </p>
            </div>

            {{-- Support Card --}}
            <div class="bg-[#003B73]/5 p-6 rounded-3xl border border-[#003B73]/10 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#003B73]/10 flex items-center justify-center text-[#003B73]">
                    <span class="material-symbols-outlined">help</span>
                </div>
                <div>
                    <p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Need help?</p>
                    <a class="text-[#003B73] font-['Work_Sans'] text-sm hover:underline" href="mailto:{{ $settings['contact_email'] ?? 'jefry.sunupurwa@esaunggul.ac.id' }}">Contact our support team</a>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
(function() {
    var pool = {!! $captcha_pool !!};
    document.getElementById('captcha-refresh-btn').addEventListener('click', function() {
        if (pool.length === 0) { alert('No more captcha available, please reload the page.'); return; }
        var next = pool.shift();
        document.getElementById('captcha-question').textContent = next.q;
        document.getElementById('captcha-token').value = next.t;
        document.getElementById('captcha-input').value = '';
    });
})();
</script>
@endpush
