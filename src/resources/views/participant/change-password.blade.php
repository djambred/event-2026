@extends('layouts.event')

@section('title', 'Change Password - Participant Portal - ' . ($settings['site_title'] ?? 'Esa Unggul International Event 2026'))

@section('content')
<section class="min-h-[70vh] flex items-center justify-center py-20 bg-[#f8f9ff]">
    <div class="max-w-lg w-full mx-auto px-6">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#E8A317]/20 text-[#8B6914] rounded-full text-xs font-['Work_Sans'] font-medium mb-4">
                <span class="material-symbols-outlined text-sm">lock_reset</span>
                Password Required
            </div>
            <h1 class="font-['Plus_Jakarta_Sans'] font-extrabold text-3xl md:text-4xl text-[#141c27] mb-3">Change Your Password</h1>
            <p class="font-['Inter'] text-[#404750]">For security, please set a new password before accessing your portal.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 font-['Inter'] text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600 text-lg">error</span>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('participant.password.update') }}" method="POST" class="bg-white p-8 rounded-3xl shadow-sm border border-[#e1e9f8]">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}"/>
            <div class="space-y-5 mb-6">
                <div class="space-y-2">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">New Password</label>
                    <input name="password" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="Enter new password (min. 8 characters)" type="password" required/>
                    @error('password')
                        <p class="text-red-500 text-xs ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="font-['Work_Sans'] text-sm font-semibold text-[#404750] ml-1">Confirm New Password</label>
                    <input name="password_confirmation" class="w-full bg-[#eff4ff] border-none rounded-xl p-4 focus:ring-2 focus:ring-[#0D5DA6] text-[#141c27] transition-all" placeholder="Confirm your new password" type="password" required/>
                </div>
            </div>
            <button class="w-full hero-gradient text-white py-4 rounded-xl font-['Plus_Jakarta_Sans'] font-bold text-lg shadow-lg shadow-[#003B73]/20 hover:scale-[1.02] transition-all active:scale-[0.98]" type="submit">
                Set New Password
            </button>
        </form>
    </div>
</section>
@endsection
