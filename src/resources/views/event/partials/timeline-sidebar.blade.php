{{-- Timeline Sidebar Partial --}}
<div class="bg-white rounded-3xl p-8 shadow-sm border border-[#e6eefd]">
    <div class="flex items-center gap-3 mb-6">
        <span class="material-symbols-outlined text-[#8B6914]">timeline</span>
        <h3 class="text-xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Timeline</h3>
    </div>
    <div class="space-y-4">
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#003B73] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Registration</p><p class="text-xs text-[#404750]">{{ $settings['registration_start'] ?? '28 Feb' }} – {{ $settings['registration_end'] ?? '1 May 2026' }}</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#0D5DA6] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Workshop & Provision</p><p class="text-xs text-[#404750]">{{ $settings['workshop_date'] ?? '4 May 2026' }} (Zoom)</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#0D5DA6] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Video Submission</p><p class="text-xs text-[#404750]">{{ $settings['video_submission_start'] ?? '5 May' }} – {{ $settings['video_submission_end'] ?? '25 May 2026' }}</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#0D5DA6] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Selection Process</p><p class="text-xs text-[#404750]">{{ $settings['selection_start'] ?? '26 May' }} – {{ $settings['selection_end'] ?? '1 Jun 2026' }}</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#8B6914] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Finalist Announcement</p><p class="text-xs text-[#404750]">{{ $settings['finalist_announcement'] ?? '2 June 2026' }}</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#8B6914] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Technical Meeting</p><p class="text-xs text-[#404750]">{{ $settings['technical_meeting_date'] ?? '6 Jun 2026' }}, {{ $settings['technical_meeting_time'] ?? '08:00 WIB' }} (Zoom)</p></div></div>
        <div class="flex gap-3 items-start"><div class="w-3 h-3 rounded-full bg-[#8B6914] mt-1.5 shrink-0"></div><div><p class="font-['Plus_Jakarta_Sans'] font-bold text-[#141c27] text-sm">Grand Final</p><p class="text-xs text-[#404750]">{{ $settings['grand_final_day1'] ?? '10 Jun' }}–{{ $settings['grand_final_day2'] ?? '11 June 2026' }}</p></div></div>
    </div>
    <div class="mt-6 p-4 bg-[#eff4ff] rounded-xl text-xs font-['Inter'] text-[#404750] space-y-1">
        <p><strong class="text-[#141c27]">Onsite:</strong> {{ $settings['venue_onsite'] ?? 'Kemala Ballroom, Universitas Esa Unggul, Jakarta' }}</p>
        <p><strong class="text-[#141c27]">Online:</strong> {{ $settings['venue_online'] ?? 'Zoom (link will be provided)' }}</p>
    </div>
</div>
