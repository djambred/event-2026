@php
    $documents = [
        [
            'label' => 'School Uniform Photo',
            'path' => $registration->school_uniform_photo,
        ],
        [
            'label' => 'Student ID / Passport',
            'path' => $registration->student_id_document,
        ],
        [
            'label' => 'Formal Photo (3x4)',
            'path' => $registration->formal_photo,
        ],
        [
            'label' => 'Proof of Payment',
            'path' => $registration->payment_proof,
        ],
    ];
@endphp

<div class="space-y-4">
    @foreach($documents as $document)
        <div class="p-4 bg-white rounded-lg border border-gray-200">
            <p class="text-sm font-semibold text-gray-900">{{ $document['label'] }}</p>

            @if(!empty($document['path']))
                @php
                    $url = Storage::disk('public')->url($document['path']);
                    $extension = strtolower(pathinfo($document['path'], PATHINFO_EXTENSION));
                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                @endphp

                <div class="mt-3 space-y-3">
                    @if($isImage)
                        <img src="{{ $url }}" alt="{{ $document['label'] }}" class="max-h-56 rounded-md border border-gray-200 object-contain" />
                    @endif

                    <a href="{{ $url }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:underline">
                        Buka berkas
                    </a>
                </div>
            @else
                <p class="mt-2 text-sm text-gray-500">Belum ada berkas.</p>
            @endif
        </div>
    @endforeach
</div>
