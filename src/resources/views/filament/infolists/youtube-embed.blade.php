@php
    $url = $getRecord()->youtube_url;
    $videoId = null;
    if ($url && preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
        $videoId = $matches[1];
    }
@endphp

@if($videoId)
    <div class="rounded-lg overflow-hidden" style="max-width: 560px;">
        <iframe
            width="560"
            height="315"
            src="https://www.youtube.com/embed/{{ $videoId }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            class="rounded-lg"
        ></iframe>
    </div>
@else
    <p class="text-sm text-gray-500">Invalid YouTube URL</p>
@endif
