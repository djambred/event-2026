@extends('layouts.event')

@section('title', 'Login - Participant Portal - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-20 bg-[#f8f9ff]">
    <div class="max-w-lg w-full mx-auto px-6">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#FFF0C8] text-[#3D2B00] rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                <span class="material-symbols-outlined text-sm">login</span>
                Participant Portal
            </div>
            <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl text-[#141c27] mb-3">Login to Portal</h1>
            <p class="font-['Inter'] text-[#404750]">Enter your registered email and password to access your portal.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 font-['Inter'] text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600 text-lg">error</span>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 font-['Inter'] text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600 text-lg">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('participant.login.post') }}" method="POST" class="bg-white p-8 rounded-3xl shadow-sm border border-[#e1e9f8]">
            @csrf
            <div class="space-y-5 mb-6">
                <div class="space-y-2">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Email Address</label>
                    <input name="email" value="{{ old('email') }}" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="Enter your registered email" type="email" required/>
                    @error('email')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Password</label>
                    <input name="password" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="Enter your password" type="password" required/>
                    @error('password')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button class="w-full hero-gradient text-white py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg shadow-lg shadow-[#003B73]/20 hover:scale-[1.02] transition-all active:scale-[0.98]" type="submit">
                Login
            </button>
        </form>

        <p class="text-center text-xs text-[#404750] mt-6 font-['Inter']">
            Default password: <span class="font-mono font-semibold text-[#003B73]">ueuevent2026</span>
        </p>
        <p class="text-center text-xs text-[#404750] mt-2 font-['Inter']">
            Can't find your registration? <a href="mailto:{{ $settings['contact_email'] ?? 'lbk@esaunggul.ac.id' }}" class="text-[#003B73] font-semibold hover:underline">Contact us</a>
        </p>
    </div>
</section>
@endsection
