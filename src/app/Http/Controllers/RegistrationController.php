<?php

namespace App\Http\Controllers;

use App\Models\CompetitionCategory;
use App\Models\EventSetting;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
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

    public function national()
    {
        $categories = CompetitionCategory::where('is_active', true)
            ->where('is_national', true)
            ->get();
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $captcha = $this->generateCaptcha();

        return view('event.registration-national', compact('categories', 'settings') + $captcha);
    }

    public function international()
    {
        $categories = CompetitionCategory::where('is_active', true)
            ->where('is_international', true)
            ->get();
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();
        $captcha = $this->generateCaptcha();

        return view('event.registration-international', compact('categories', 'settings') + $captcha);
    }

    public function storeNational(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => ['required', 'string', 'max:30', 'regex:/^(\+?62|0)8[1-9][0-9]{6,11}$/'],
            'institution' => 'required|string|max:255',
            'competition_category_id' => 'required|exists:competition_categories,id',
            'school_uniform_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'youtube_url' => 'nullable|url|max:500',
            'captcha_answer' => 'required|integer',
            'captcha_token' => 'required|string',
        ]);

        if (!$this->verifyCaptcha($request)) {
            return back()->withErrors(['captcha_answer' => 'Captcha answer is incorrect.'])->withInput();
        }

        $validated['registration_type'] = 'national';

        if ($request->hasFile('school_uniform_photo')) {
            $validated['school_uniform_photo'] = $request->file('school_uniform_photo')
                ->store('registrations/uniform-photos', 'public');
        }

        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')
                ->store('registrations/payment-proofs', 'public');
        }

        $registerKey = Registration::generateRegisterKey();
        $validated['password'] = Hash::make($registerKey);
        $validated['password_changed'] = true;

        $registration = Registration::create($validated);

        session(['participant_token' => $registration->access_token]);

        return redirect()->route('participant.portal')
            ->with('register_key', $registerKey);
    }

    public function storeInternational(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => ['required', 'string', 'max:30', 'regex:/^\+?[1-9][0-9]{7,15}$/'],
            'institution' => 'required|string|max:255',
            'competition_category_id' => 'required|exists:competition_categories,id',
            'student_id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'formal_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'youtube_url' => 'nullable|url|max:500',
            'captcha_answer' => 'required|integer',
            'captcha_token' => 'required|string',
        ]);

        if (!$this->verifyCaptcha($request)) {
            return back()->withErrors(['captcha_answer' => 'Captcha answer is incorrect.'])->withInput();
        }

        $validated['registration_type'] = 'international';

        if ($request->hasFile('student_id_document')) {
            $validated['student_id_document'] = $request->file('student_id_document')
                ->store('registrations/id-documents', 'public');
        }

        if ($request->hasFile('formal_photo')) {
            $validated['formal_photo'] = $request->file('formal_photo')
                ->store('registrations/formal-photos', 'public');
        }

        $registerKey = Registration::generateRegisterKey();
        $validated['password'] = Hash::make($registerKey);
        $validated['password_changed'] = true;

        $registration = Registration::create($validated);

        session(['participant_token' => $registration->access_token]);

        return redirect()->route('participant.portal')
            ->with('register_key', $registerKey);
    }
}
