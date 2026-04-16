<?php

namespace App\Services;

use App\Models\CertificateTemplate;
use App\Models\Registration;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function generate(Registration $registration, string $type = 'participation'): string
    {
        $template = $registration->competitionCategory->getActiveCertificateTemplate($type);

        if (!$template) {
            throw new \RuntimeException("No active {$type} certificate template found for this category.");
        }

        $backgroundPath = Storage::disk('public')->path($template->background_image);

        if (!file_exists($backgroundPath)) {
            throw new \RuntimeException('Certificate template background image not found.');
        }

        $image = $this->loadImage($backgroundPath);

        if (!$image) {
            throw new \RuntimeException('Failed to load certificate template image.');
        }

        $imgWidth = imagesx($image);
        $imgHeight = imagesy($image);

        // Allocate colors
        $nameColor = $this->hexToColor($image, $template->name_color ?? '#000000');
        $categoryColor = $this->hexToColor($image, $template->category_color ?? '#000000');

        $fontPath = resource_path('fonts/PlusJakartaSans-Bold.ttf');
        $hasTtf = file_exists($fontPath);

        // Convert % positions to pixel coordinates
        $namePixelX = intval($imgWidth * $template->name_x / 100);
        $namePixelY = intval($imgHeight * $template->name_y / 100);
        $catPixelX = intval($imgWidth * $template->category_x / 100);
        $catPixelY = intval($imgHeight * $template->category_y / 100);

        // Add participant name (centered horizontally at X%)
        $this->addCenteredText(
            $image,
            $registration->full_name,
            $namePixelX,
            $namePixelY,
            $template->name_font_size ?? 32,
            $nameColor,
            $fontPath,
            $hasTtf
        );

        // Add category name (centered horizontally at X%)
        $this->addCenteredText(
            $image,
            $registration->competitionCategory->name,
            $catPixelX,
            $catPixelY,
            $template->category_font_size ?? 24,
            $categoryColor,
            $fontPath,
            $hasTtf
        );

        // Add rank text for winner certificates
        if ($type === 'winner' && $registration->rank) {
            $rankColor = $this->hexToColor($image, $template->rank_color ?? '#E8A317');
            $rankText = $this->getRankLabel($registration->rank);
            $rankPixelX = intval($imgWidth * ($template->rank_x ?? 50) / 100);
            $rankPixelY = intval($imgHeight * ($template->rank_y ?? 70) / 100);

            $this->addCenteredText(
                $image,
                $rankText,
                $rankPixelX,
                $rankPixelY,
                $template->rank_font_size ?? 28,
                $rankColor,
                $fontPath,
                $hasTtf
            );
        }

        // Save certificate
        $directory = 'certificates';
        Storage::disk('public')->makeDirectory($directory);

        $filename = $directory . '/cert-' . $type . '-' . $registration->id . '-' . time() . '.png';
        $outputPath = Storage::disk('public')->path($filename);

        imagepng($image, $outputPath);
        imagedestroy($image);

        return $filename;
    }

    private function getRankLabel(int $rank): string
    {
        return match ($rank) {
            1 => '1st Place - Champion',
            2 => '2nd Place - Runner Up',
            3 => '3rd Place',
            default => "Rank #{$rank}",
        };
    }

    private function loadImage(string $path): \GdImage|false
    {
        $info = getimagesize($path);

        if (!$info) {
            return false;
        }

        return match ($info[2]) {
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            default => false,
        };
    }

    private function hexToColor(\GdImage $image, string $hex): int
    {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return imagecolorallocate($image, $r, $g, $b);
    }

    private function addCenteredText(
        \GdImage $image,
        string $text,
        int $centerX,
        int $y,
        int $fontSize,
        int $color,
        string $fontPath,
        bool $hasTtf
    ): void {
        if ($hasTtf) {
            // Calculate text bounding box to center it
            $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
            $textWidth = abs($bbox[2] - $bbox[0]);
            $x = $centerX - intval($textWidth / 2);
            imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
        } else {
            $builtinFont = min(5, max(1, intval($fontSize / 8)));
            $textWidth = imagefontwidth($builtinFont) * strlen($text);
            $x = $centerX - intval($textWidth / 2);
            imagestring($image, $builtinFont, $x, $y, $text, $color);
        }
    }
}
