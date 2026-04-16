{{-- Judging Criteria Sidebar Partial --}}
<div class="bg-white rounded-3xl p-8 shadow-sm border border-[#e6eefd]">
    <div class="flex items-center gap-3 mb-6">
        <span class="material-symbols-outlined text-[#003B73]">scoreboard</span>
        <h3 class="text-xl font-['Plus_Jakarta_Sans'] font-bold text-[#141c27]">Judging Criteria</h3>
    </div>
    <div class="space-y-3">
        @foreach(explode("\n", $judgingData) as $line)
            @php $parts = explode('|', trim($line)); @endphp
            @if(count($parts) >= 2)
            <div class="flex justify-between items-center p-3 bg-[#eff4ff] rounded-xl">
                <span class="text-sm font-['Inter'] text-[#141c27]">{{ trim($parts[0]) }}</span>
                <span class="font-['Plus_Jakarta_Sans'] font-black text-[#003B73]">{{ trim($parts[1]) }}</span>
            </div>
            @endif
        @endforeach
    </div>
    <p class="mt-4 text-xs text-[#404750] font-['Inter'] bg-[#FFF0C8] rounded-lg p-3 text-center font-semibold">Judges' decisions are final and cannot be contested.</p>
</div>
