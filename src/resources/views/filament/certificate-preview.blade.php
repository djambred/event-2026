<div class="space-y-4">
    {{-- Actual Certificate Preview (matches PDF output) --}}
    <div class="border rounded-lg overflow-hidden shadow-sm" style="aspect-ratio: 297/210;">
        @if($template->background_image)
        {{-- Custom background image preview --}}
        <div style="position: relative; width: 100%; height: 0; padding-bottom: 70.7%; overflow: hidden; background: #fff;">
            <img src="{{ Storage::disk('public')->url($template->background_image) }}"
                 alt="Certificate Background"
                 style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">

            {{-- Participant Name --}}
            <div style="position: absolute; left: {{ $template->name_x }}%; top: {{ $template->name_y }}%; transform: translateX(-50%); text-align: center; font-size: {{ max(8, $template->name_font_size * 0.35) }}px; color: {{ $template->name_color ?? '#000000' }}; font-weight: bold; white-space: nowrap; font-family: Helvetica, Arial, sans-serif;">
                John Doe
            </div>

            {{-- Category Name --}}
            <div style="position: absolute; left: {{ $template->category_x }}%; top: {{ $template->category_y }}%; transform: translateX(-50%); text-align: center; font-size: {{ max(6, ($template->category_font_size ?? 24) * 0.35) }}px; color: {{ $template->category_color ?? '#333333' }}; font-weight: bold; white-space: nowrap; font-family: Helvetica, Arial, sans-serif;">
                {{ $template->competitionCategory?->name ?? 'Storytelling' }}
            </div>

            @if($template->type === 'winner')
            {{-- Rank Text --}}
            <div style="position: absolute; left: {{ $template->rank_x ?? 50 }}%; top: {{ $template->rank_y ?? 70 }}%; transform: translateX(-50%); text-align: center; font-size: {{ max(7, ($template->rank_font_size ?? 28) * 0.35) }}px; color: {{ $template->rank_color ?? '#E8A317' }}; font-weight: bold; white-space: nowrap; font-family: Helvetica, Arial, sans-serif;">
                1st Place - Champion
            </div>
            @endif
        </div>
        @else
        {{-- Default HTML design preview --}}
        <div style="position: relative; width: 100%; height: 0; padding-bottom: 70.7%; overflow: hidden; background: #ffffff; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%230574b9\' fill-opacity=\'0.04\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            {{-- Outer border --}}
            <div style="position: absolute; top: 2%; left: 1.5%; right: 1.5%; bottom: 2%; border: 8px solid #e1e9f8;"></div>
            {{-- Inner border --}}
            <div style="position: absolute; top: 5%; left: 4%; right: 4%; bottom: 5%; border: 1px solid rgba(0, 91, 147, 0.2);"></div>

            {{-- Header --}}
            <div style="position: absolute; top: 8%; left: 8%; font-family: Helvetica, Arial, sans-serif;">
                <div style="font-size: 8px; font-weight: bold; color: #005b93; letter-spacing: 0.5px;">UNIVERSITAS ESA UNGGUL</div>
                <div style="font-size: 5px; color: #404750; text-transform: uppercase; letter-spacing: 1.5px;">Jakarta, Indonesia</div>
            </div>
            <div style="position: absolute; top: 8%; right: 8%; text-align: right; font-family: Helvetica, Arial, sans-serif;">
                <div style="font-size: 5px; color: #404750; text-transform: uppercase; letter-spacing: 1.5px;">Lembaga Bahasa dan Kebudayaan</div>
            </div>

            {{-- Badge --}}
            <div style="position: absolute; top: 22%; left: 50%; transform: translateX(-50%); background: #ffdbcb; color: #341100; font-size: 5px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; padding: 2px 8px; border-radius: 6px; font-family: Helvetica, Arial, sans-serif;">
                International Achievement
            </div>

            {{-- Title --}}
            <div style="position: absolute; top: 28%; left: 50%; transform: translateX(-50%); text-align: center; font-family: Helvetica, Arial, sans-serif;">
                <div style="font-size: 18px; font-weight: 800; color: #005b93; white-space: nowrap;">
                    {{ $template->type === 'winner' ? 'Certificate of Achievement' : 'Certificate of Participation' }}
                </div>
                <div style="width: 30px; height: 2px; background: #9f4200; margin: 5px auto; border-radius: 1px;"></div>
            </div>

            {{-- Presented to --}}
            <div style="position: absolute; top: 42%; left: 50%; transform: translateX(-50%); font-size: 7px; color: #404750; font-style: italic; font-family: Helvetica, Arial, sans-serif;">
                This highly prestigious recognition is proudly presented to
            </div>

            {{-- Name --}}
            <div style="position: absolute; top: 49%; left: 50%; transform: translateX(-50%); font-size: {{ max(10, $template->name_font_size * 0.35) }}px; font-weight: bold; color: {{ $template->name_color ?? '#001d34' }}; border-bottom: 1px solid #c0c7d2; padding-bottom: 3px; font-family: Helvetica, Arial, sans-serif;">
                John Doe
            </div>

            {{-- Category --}}
            <div style="position: absolute; top: 58%; left: 50%; transform: translateX(-50%); text-align: center; font-family: Helvetica, Arial, sans-serif;">
                <div style="font-size: 7px; color: #141c27;">For having participated in the</div>
                <div style="font-size: {{ max(7, ($template->category_font_size ?? 18) * 0.35) }}px; font-weight: bold; color: {{ $template->category_color ?? '#0574b9' }}; margin-top: 2px;">
                    {{ $template->competitionCategory?->name ?? 'Storytelling' }}
                </div>
            </div>

            @if($template->type === 'winner')
            {{-- Rank --}}
            <div style="position: absolute; top: 67%; left: 50%; transform: translateX(-50%); font-size: {{ max(7, ($template->rank_font_size ?? 28) * 0.35) }}px; font-weight: bold; color: {{ $template->rank_color ?? '#9f4200' }}; border: 1px solid {{ $template->rank_color ?? '#9f4200' }}; padding: 2px 10px; border-radius: 2px; font-family: Helvetica, Arial, sans-serif;">
                1st Place - Champion
            </div>
            @endif

            {{-- Signature labels --}}
            <div style="position: absolute; bottom: 10%; left: 12%; text-align: center; font-family: Helvetica, Arial, sans-serif;">
                <div style="width: 50px; border-bottom: 1px solid #707882; margin: 0 auto 3px; height: 15px;"></div>
                <div style="font-size: 4px; color: #404750; text-transform: uppercase; letter-spacing: 1px;">Director of LBK</div>
            </div>
            <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); text-align: center; font-family: Helvetica, Arial, sans-serif;">
                <img src="{{ asset('seal.png') }}" alt="Official Seal" style="width: 30px; height: 30px; margin: 0 auto 3px; display: block;">
                <div style="font-size: 4px; color: rgba(64,71,80,0.5); text-transform: uppercase; letter-spacing: 1px;">Official Seal</div>
            </div>
            <div style="position: absolute; bottom: 10%; right: 12%; text-align: center; font-family: Helvetica, Arial, sans-serif;">
                <div style="width: 50px; border-bottom: 1px solid #707882; margin: 0 auto 3px; height: 15px;"></div>
                <div style="font-size: 4px; color: #404750; text-transform: uppercase; letter-spacing: 1px;">Rector</div>
            </div>
        </div>
        @endif
    </div>

    <p class="text-xs text-gray-500 text-center italic">
        Preview is scaled down. Actual PDF is A4 Landscape (297×210mm).
        @if(!$template->background_image)
        <br>Using built-in HTML certificate design (no background image uploaded).
        @endif
    </p>

    {{-- Template Details --}}
    <div class="grid grid-cols-2 gap-3 text-sm bg-gray-50 rounded-lg p-4">
        <div>
            <span class="font-semibold text-gray-700">Type:</span>
            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $template->type === 'winner' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ $template->type === 'winner' ? 'Winner' : 'Participation' }}
            </span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Category:</span>
            <span class="ml-1 text-gray-600">{{ $template->competitionCategory?->name ?? 'General' }}</span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Background:</span>
            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $template->background_image ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $template->background_image ? 'Custom Image' : 'Built-in HTML' }}
            </span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Status:</span>
            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $template->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        @if($template->background_image)
        <div>
            <span class="font-semibold text-gray-700">Name:</span>
            <span class="ml-1 text-gray-600">{{ $template->name_x }}%, {{ $template->name_y }}% · {{ $template->name_font_size }}px · <span style="color: {{ $template->name_color }}">{{ $template->name_color }}</span></span>
        </div>
        <div>
            <span class="font-semibold text-gray-700">Category:</span>
            <span class="ml-1 text-gray-600">{{ $template->category_x }}%, {{ $template->category_y }}% · {{ $template->category_font_size ?? 24 }}px · <span style="color: {{ $template->category_color ?? '#333' }}">{{ $template->category_color ?? '#333333' }}</span></span>
        </div>
        @if($template->type === 'winner')
        <div>
            <span class="font-semibold text-gray-700">Rank:</span>
            <span class="ml-1 text-gray-600">{{ $template->rank_x ?? 50 }}%, {{ $template->rank_y ?? 70 }}% · {{ $template->rank_font_size ?? 28 }}px · <span style="color: {{ $template->rank_color ?? '#E8A317' }}">{{ $template->rank_color ?? '#E8A317' }}</span></span>
        </div>
        @endif
        @endif
    </div>
</div>
