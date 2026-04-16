<div class="space-y-4">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-bold text-lg text-blue-900">{{ $announcement->competitionCategory->name }}</h3>
        <p class="text-blue-700 text-sm">{{ $announcement->title }}</p>
    </div>

    @if($winners->isNotEmpty())
        <div class="space-y-3">
            @foreach($winners as $winner)
                <div class="flex items-center gap-4 p-4 rounded-lg border {{ $winner->rank === 1 ? 'bg-yellow-50 border-yellow-300' : ($winner->rank === 2 ? 'bg-gray-50 border-gray-300' : 'bg-orange-50 border-orange-200') }}">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-bold text-white text-lg {{ $winner->rank === 1 ? 'bg-yellow-500' : ($winner->rank === 2 ? 'bg-gray-400' : 'bg-orange-400') }}">
                        {{ $winner->rank }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $winner->full_name }}</p>
                        <p class="text-sm text-gray-500">{{ $winner->institution }} &middot; {{ ucfirst($winner->registration_type) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-mono font-bold text-lg">{{ number_format($winner->final_score, 2) }}</p>
                        <p class="text-xs text-gray-500">Final Score</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <p class="text-lg font-medium">No winners found</p>
            <p class="text-sm">Make sure participants have been scored and ranked in this category.</p>
        </div>
    @endif
</div>
