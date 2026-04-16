<div class="space-y-4">
    @if($template->background_image)
        <div class="relative border rounded-lg overflow-hidden">
            <img src="{{ Storage::disk('public')->url($template->background_image) }}"
                 alt="Certificate Background"
                 class="w-full">
            {{-- Name position indicator --}}
            <div class="absolute text-center"
                 style="left: {{ $template->name_x }}%; top: {{ $template->name_y }}%; transform: translate(-50%, -50%); font-size: {{ max(8, $template->name_font_size / 4) }}px; color: {{ $template->name_color ?? '#000000' }}; font-weight: bold;">
                [Participant Name]
            </div>
            {{-- Category position indicator --}}
            <div class="absolute text-center"
                 style="left: {{ $template->category_x }}%; top: {{ $template->category_y }}%; transform: translate(-50%, -50%); font-size: {{ max(6, ($template->category_font_size ?? 24) / 4) }}px; color: {{ $template->category_color ?? '#333333' }}; font-weight: bold;">
                [Category Name]
            </div>
            @if($template->type === 'winner')
            {{-- Rank position indicator --}}
            <div class="absolute text-center"
                 style="left: {{ $template->rank_x ?? 50 }}%; top: {{ $template->rank_y ?? 70 }}%; transform: translate(-50%, -50%); font-size: {{ max(7, ($template->rank_font_size ?? 28) / 4) }}px; color: {{ $template->rank_color ?? '#E8A317' }}; font-weight: bold;">
                [1st Place - Champion]
            </div>
            @endif
        </div>
    @else
        <p class="text-gray-500">No background image uploaded yet.</p>
    @endif

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <strong>Type:</strong> {{ ucfirst($template->type) }}
        </div>
        <div>
            <strong>Category:</strong> {{ $template->competitionCategory?->name ?? 'General' }}
        </div>
        <div>
            <strong>Name Position:</strong> X={{ $template->name_x }}%, Y={{ $template->name_y }}%
        </div>
        <div>
            <strong>Name Style:</strong> {{ $template->name_font_size }}px, {{ $template->name_color }}
        </div>
        <div>
            <strong>Category Position:</strong> X={{ $template->category_x }}%, Y={{ $template->category_y }}%
        </div>
        <div>
            <strong>Category Style:</strong> {{ $template->category_font_size }}px, {{ $template->category_color }}
        </div>
        @if($template->type === 'winner')
        <div>
            <strong>Rank Position:</strong> X={{ $template->rank_x ?? 50 }}%, Y={{ $template->rank_y ?? 70 }}%
        </div>
        <div>
            <strong>Rank Style:</strong> {{ $template->rank_font_size ?? 28 }}px, {{ $template->rank_color ?? '#E8A317' }}
        </div>
        @endif
    </div>
</div>
