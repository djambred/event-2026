<?php

namespace App\Http\Controllers;

use App\Models\EventSetting;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function loginForm()
    {
        if (session('participant_token')) {
            return redirect()->route('participant.portal');
        }

        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        return view('participant.lookup', compact('settings'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

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

        return view('participant.change-password', compact('settings', 'token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

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

        return view('participant.portal', compact('registration', 'settings'));
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

        $registration = Registration::where('access_token', $token)->firstOrFail();

        $type = $request->query('type', 'participation');
        $certFile = match ($type) {
            'winner' => $registration->winner_certificate,
            default => $registration->participation_certificate ?? $registration->certificate_file,
        };

        if (!$certFile || !Storage::disk('public')->exists($certFile)) {
            abort(404, 'Certificate not available yet.');
        }

        return Storage::disk('public')->download(
            $certFile,
            'certificate-' . $type . '-' . \Illuminate\Support\Str::slug($registration->full_name) . '.png'
        );
    }

    public function logout()
    {
        session()->forget('participant_token');

        return redirect()->route('participant.login')->with('success', 'Logged out successfully.');
    }
}
