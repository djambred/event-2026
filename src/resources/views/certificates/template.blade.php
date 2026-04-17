<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 0;
            size: 297mm 210mm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            width: 297mm;
            height: 210mm;
            position: relative;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }
        .certificate-wrapper {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
        }

        @if(!empty($backgroundBase64))
        /* === MODE: Custom Background Image === */
        .background {
            width: 297mm;
            height: 210mm;
            position: absolute;
            top: 0;
            left: 0;
        }
        .overlay-text {
            position: absolute;
            text-align: center;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        .participant-name {
            left: {{ $template->name_x }}%;
            top: {{ $template->name_y }}%;
            font-size: {{ $template->name_font_size ?? 36 }}px;
            color: {{ $template->name_color ?? '#000000' }};
            font-weight: bold;
        }
        .category-name {
            left: {{ $template->category_x }}%;
            top: {{ $template->category_y }}%;
            font-size: {{ $template->category_font_size ?? 24 }}px;
            color: {{ $template->category_color ?? '#333333' }};
            font-weight: bold;
        }
        @if($template->type === 'winner')
        .rank-text {
            left: {{ $template->rank_x ?? 50 }}%;
            top: {{ $template->rank_y ?? 70 }}%;
            font-size: {{ $template->rank_font_size ?? 28 }}px;
            color: {{ $template->rank_color ?? '#E8A317' }};
            font-weight: bold;
        }
        @endif

        @else
        /* === MODE: Default HTML Certificate Design === */
        .default-cert {
            width: 297mm;
            height: 210mm;
            position: absolute;
            top: 0;
            left: 0;
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230574b9' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Outer decorative border */
        .border-outer {
            position: absolute;
            top: 4mm;
            left: 4mm;
            right: 4mm;
            bottom: 4mm;
            border: 4mm solid #e1e9f8;
        }
        /* Inner decorative border */
        .border-inner {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 0.5mm solid rgba(0, 91, 147, 0.2);
        }

        /* Header - left */
        .header-left {
            position: absolute;
            top: 18mm;
            left: 22mm;
        }
        .institution-name {
            font-size: 14px;
            font-weight: bold;
            color: #005b93;
            letter-spacing: 1px;
        }
        .institution-sub {
            font-size: 9px;
            color: #404750;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 2px;
        }
        /* Header - right */
        .header-right {
            position: absolute;
            top: 20mm;
            right: 22mm;
            text-align: right;
        }

        /* Center content */
        .cert-center {
            position: absolute;
            top: 38mm;
            left: 0;
            right: 0;
            text-align: center;
        }

        /* Badge */
        .cert-badge {
            display: inline-block;
            padding: 3px 16px;
            background-color: #ffdbcb;
            color: #341100;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            border-radius: 12px;
            margin-bottom: 6mm;
        }

        /* Title */
        .cert-title {
            font-size: 40px;
            font-weight: 800;
            color: #005b93;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        .cert-title-line {
            width: 25mm;
            height: 1mm;
            background-color: #9f4200;
            margin: 4mm auto;
        }

        /* Presented to */
        .cert-presented {
            font-size: 13px;
            color: #404750;
            font-style: italic;
            margin-bottom: 3mm;
        }

        /* Participant name */
        .cert-name {
            font-size: {{ $template->name_font_size ?? 36 }}px;
            font-weight: bold;
            color: {{ $template->name_color ?? '#001d34' }};
            padding-bottom: 2mm;
            border-bottom: 0.5mm solid #c0c7d2;
            display: inline-block;
            min-width: 100mm;
        }

        /* Category + description */
        .cert-description {
            font-size: 14px;
            color: #141c27;
            line-height: 1.6;
            margin-top: 5mm;
        }
        .cert-category-highlight {
            font-size: {{ $template->category_font_size ?? 18 }}px;
            font-weight: bold;
            color: {{ $template->category_color ?? '#0574b9' }};
        }
        .cert-event-info {
            font-size: 11px;
            color: #404750;
            margin-top: 2mm;
            line-height: 1.5;
        }

        /* Rank (winner only) */
        @if($template->type === 'winner')
        .cert-rank {
            font-size: {{ $template->rank_font_size ?? 28 }}px;
            font-weight: bold;
            color: {{ $template->rank_color ?? '#9f4200' }};
            margin-top: 4mm;
            display: inline-block;
            padding: 2mm 8mm;
            border: 0.5mm solid {{ $template->rank_color ?? '#9f4200' }};
        }
        @endif

        /* Signatures - absolute positioned at bottom */
        .sig-left {
            position: absolute;
            bottom: 18mm;
            left: 30mm;
            text-align: center;
        }
        .sig-center {
            position: absolute;
            bottom: 18mm;
            left: 50%;
            margin-left: -15mm;
            text-align: center;
            width: 30mm;
        }
        .sig-right {
            position: absolute;
            bottom: 18mm;
            right: 30mm;
            text-align: center;
        }
        .sig-line {
            width: 35mm;
            border-bottom: 0.3mm solid #707882;
            margin: 0 auto 2mm auto;
            height: 12mm;
        }
        .sig-title {
            font-size: 7px;
            color: #404750;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        /* Seal */
        .seal-img {
            width: 22mm;
            height: 22mm;
            margin: 0 auto 2mm auto;
        }
        .seal-label {
            font-size: 6px;
            color: rgba(64, 71, 80, 0.5);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Footer serial */
        .cert-serial {
            position: absolute;
            bottom: 8mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7px;
            color: #c0c7d2;
            text-transform: uppercase;
            letter-spacing: 4px;
        }
        @endif
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        @if(!empty($backgroundBase64))
            {{-- Custom background image mode --}}
            <img class="background" src="{{ $backgroundBase64 }}" alt="Certificate">
            <div class="overlay-text participant-name">{{ $participantName }}</div>
            <div class="overlay-text category-name">{{ $categoryName }}</div>
            @if($template->type === 'winner' && !empty($rankText))
            <div class="overlay-text rank-text">{{ $rankText }}</div>
            @endif
        @else
            {{-- Default HTML certificate design --}}
            <div class="default-cert">
                <div class="border-outer"></div>
                <div class="border-inner"></div>

                {{-- Header --}}
                <div class="header-left">
                    <div class="institution-name">UNIVERSITAS ESA UNGGUL</div>
                    <div class="institution-sub">Jakarta, Indonesia</div>
                </div>
                <div class="header-right">
                    <div class="institution-sub">Lembaga Bahasa dan Kebudayaan</div>
                </div>

                {{-- Main content --}}
                <div class="cert-center">
                    <div class="cert-badge">International Achievement</div>
                    <br>
                    <div class="cert-title">
                        @if($template->type === 'winner')
                            Certificate of Achievement
                        @else
                            Certificate of Participation
                        @endif
                    </div>
                    <div class="cert-title-line"></div>

                    <div class="cert-presented">This highly prestigious recognition is proudly presented to</div>

                    <div class="cert-name">{{ $participantName }}</div>

                    <div class="cert-description">
                        For having participated in the
                        <span class="cert-category-highlight">{{ $categoryName }}</span>
                    </div>
                    <div class="cert-event-info">
                        Held at Universitas Esa Unggul as part of the<br>
                        Esa Unggul International Event: Pioneering Global Excellence
                    </div>

                    @if($template->type === 'winner' && !empty($rankText))
                    <div class="cert-rank">{{ $rankText }}</div>
                    @endif
                </div>

                {{-- Signatures --}}
                <div class="sig-left">
                    <div class="sig-line"></div>
                    <div class="sig-title">Director of LBK</div>
                </div>
                <div class="sig-center">
                    <img class="seal-img" src="{{ $sealBase64 }}" alt="Official Seal">
                    <div class="seal-label">Official Seal</div>
                </div>
                <div class="sig-right">
                    <div class="sig-line"></div>
                    <div class="sig-title">Rector of Universitas Esa Unggul</div>
                </div>

                <div class="cert-serial">
                    Certificate Serial: UEU-INT-{{ date('Y') }}-{{ str_pad($template->id ?? 0, 4, '0', STR_PAD_LEFT) }}-{{ str_pad(abs(crc32($participantName)) % 10000, 4, '0', STR_PAD_LEFT) }}
                </div>
            </div>
        @endif
    </div>
</body>
</html>
