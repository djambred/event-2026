<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\EventSetting;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParticipantController extends Controller
{
    private static function signCaptcha(int $answer): string
    {
        return hash_hmac('sha256', (string) $answer, config('app.key'));
    }

    private function generateCaptcha(): array
    {
        $pool = [];
        for ($i = 0; $i < 10; $i++) {
            $a = rand(1, 10);
            $b = rand(1, 10);
            $answer = $a + $b;
            $pool[] = [
                'q' => "{$a} + {$b}",
                't' => self::signCaptcha($answer),
            ];
        }

        return [
            'captcha_question' => $pool[0]['q'],
            'captcha_token' => $pool[0]['t'],
            'captcha_pool' => json_encode(array_slice($pool, 1)),
        ];
    }

    private function verifyCaptcha(Request $request): bool
    {
        $answer = (int) $request->input('captcha_answer');
        $token = (string) $request->input('captcha_token');

        return hash_equals(self::signCaptcha($answer), $token);
    }

    public function loginForm()
    {
        if (session('participant_token')) {
            return redirect()->route('participant.portal');
        }

        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $captcha = $this->generateCaptcha();

        return view('participant.lookup', compact('settings') + $captcha);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'captcha_answer' => 'required|integer',
            'captcha_token' => 'required|string',
        ]);

        if (!$this->verifyCaptcha($request)) {
            return back()->withErrors(['captcha_answer' => 'Captcha answer is incorrect.'])->withInput(['email' => $request->email]);
        }

        $registration = Registration::where('email', $request->email)->first();

        if (!$registration || !Hash::check($request->password, $registration->password)) {
            return back()->with('error', 'Invalid email or password.')->withInput(['email' => $request->email]);
        }

        session(['participant_token' => $registration->access_token]);

        if (!$registration->password_changed) {
            return redirect()->route('participant.password.change');
        }

        return redirect()->route('participant.portal');
    }

    public function changePasswordForm()
    {
        $token = session('participant_token');
        if (!$token) {
            return redirect()->route('participant.login');
        }

        $registration = Registration::where('access_token', $token)->firstOrFail();
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $captcha = $this->generateCaptcha();

        return view('participant.change-password', compact('settings', 'token') + $captcha);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'captcha_answer' => 'required|integer',
            'captcha_token' => 'required|string',
        ]);

        if (!$this->verifyCaptcha($request)) {
            return back()->withErrors(['captcha_answer' => 'Captcha answer is incorrect.'])->withInput();
        }

        $registration = Registration::where('access_token', $request->token)->firstOrFail();

        if (session('participant_token') !== $registration->access_token) {
            return redirect()->route('participant.login');
        }

        $registration->update([
            'password' => Hash::make($request->password),
            'password_changed' => true,
        ]);

        return redirect()->route('participant.portal')->with('success', 'Password changed successfully!');
    }

    public function portal()
    {
        $token = session('participant_token');
        if (!$token) {
            return redirect()->route('participant.login');
        }

        $registration = Registration::where('access_token', $token)
            ->with([
                'competitionCategory.judgingCriterias',
                'scores.judgingCriteria',
            ])
            ->firstOrFail();

        if (!$registration->password_changed) {
            return redirect()->route('participant.password.change');
        }

        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        $announcements = Announcement::where('competition_category_id', $registration->competition_category_id)
            ->where('is_published', true)
            ->latest('published_at')
            ->get();

        $hasParticipationCert = (bool) $registration->competitionCategory->getActiveCertificateTemplate('participation');
        $hasWinnerCert = $registration->rank
            ? (bool) $registration->competitionCategory->getActiveCertificateTemplate('winner')
            : false;

        return view('participant.portal', compact('registration', 'settings', 'announcements', 'hasParticipationCert', 'hasWinnerCert'));
    }

    public function updateYoutube(Request $request)
    {
        $token = session('participant_token');
        if (!$token) {
            return redirect()->route('participant.login');
        }

        $request->validate([
            'youtube_url' => 'nullable|url|max:500',
        ]);

        $registration = Registration::where('access_token', $token)->firstOrFail();
        $registration->update(['youtube_url' => $request->youtube_url]);

        return redirect()->route('participant.portal')->with('success', 'YouTube video URL updated successfully!');
    }

    public function downloadCertificate(Request $request)
    {
        $token = session('participant_token');
        if (!$token) {
            return redirect()->route('participant.login');
        }

        $registration = Registration::where('access_token', $token)
            ->with('competitionCategory')
            ->firstOrFail();

        $type = $request->query('type', 'participation');

        if (!in_array($type, ['participation', 'winner'])) {
            abort(404);
        }

        // Check if active template exists for this category+type
        $hasTemplate = (bool) $registration->competitionCategory->getActiveCertificateTemplate($type);

        if (!$hasTemplate) {
            abort(404, 'Certificate not available yet.');
        }

        if ($type === 'winner' && !$registration->rank) {
            abort(404, 'Certificate not available yet.');
        }

        try {
            $service = new \App\Services\CertificateService();
            $pdfContent = $service->generatePdf($registration, $type);
        } catch (\RuntimeException $e) {
            abort(404, $e->getMessage());
        }

        $filename = 'certificate-' . $type . '-' . \Illuminate\Support\Str::slug($registration->full_name) . '.pdf';

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function logout()
    {
        session()->forget('participant_token');

        return redirect()->route('participant.login')->with('success', 'Logged out successfully.');
    }
}
