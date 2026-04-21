<?php

namespace App\Services;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    /**
     * Generate a certificate PDF on-the-fly and return the binary content.
     */
    public function generatePdf(Registration $registration, string $type = 'participation'): string
    {
        $template = $registration->competitionCategory->getActiveCertificateTemplate($type);

        if (!$template) {
            throw new \RuntimeException("No active {$type} certificate template found for this category.");
        }

        $backgroundBase64 = null;

        if ($template->background_image) {
            $backgroundPath = Storage::disk('public')->path($template->background_image);

            if (file_exists($backgroundPath)) {
                $mime = mime_content_type($backgroundPath);
                $base64 = base64_encode(file_get_contents($backgroundPath));
                $backgroundBase64 = "data:{$mime};base64,{$base64}";
            }
        }

        $rankText = '';

        // Seal image
        $sealPath = public_path('seal.png');
        $sealBase64 = '';
        if (file_exists($sealPath)) {
            $sealMime = mime_content_type($sealPath);
            $sealBase64 = 'data:' . $sealMime . ';base64,' . base64_encode(file_get_contents($sealPath));
        }

        $html = view('certificates.template', [
            'template' => $template,
            'backgroundBase64' => $backgroundBase64,
            'sealBase64' => $sealBase64,
            'participantName' => $registration->full_name,
            'categoryName' => $registration->competitionCategory->name,
            'rankText' => $rankText,
        ])->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setOption('isRemoteEnabled', true)
            ->setOption('dpi', 150);

        return $pdf->output();
    }

    /**
     * Generate and save certificate to storage (legacy, for pre-generating).
     */
    public function generate(Registration $registration, string $type = 'participation'): string
    {
        $pdfContent = $this->generatePdf($registration, $type);

        $directory = 'certificates';
        Storage::disk('public')->makeDirectory($directory);

        $filename = $directory . '/cert-' . $type . '-' . $registration->id . '-' . time() . '.pdf';
        Storage::disk('public')->put($filename, $pdfContent);

        return $filename;
    }


}
