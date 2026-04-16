<?php

namespace App\Http\Controllers;

use App\Models\CompetitionCategory;
use App\Models\EventSetting;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function national()
    {
        $categories = CompetitionCategory::where('is_active', true)
            ->where('is_national', true)
            ->get();
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        return view('event.registration-national', compact('categories', 'settings'));
    }

    public function international()
    {
        $categories = CompetitionCategory::where('is_active', true)
            ->where('is_international', true)
            ->get();
        $settings = EventSetting::all()->pluck('value', 'key')->toArray();

        return view('event.registration-international', compact('categories', 'settings'));
    }

    public function storeNational(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'competition_category_id' => 'required|exists:competition_categories,id',
            'school_uniform_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'youtube_url' => 'nullable|url|max:500',
        ]);

        $validated['registration_type'] = 'national';

        if ($request->hasFile('school_uniform_photo')) {
            $validated['school_uniform_photo'] = $request->file('school_uniform_photo')
                ->store('registrations/uniform-photos', 'public');
        }

        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')
                ->store('registrations/payment-proofs', 'public');
        }

        Registration::create($validated);

        return redirect()->route('registration.national')
            ->with('success', 'Registration submitted successfully! We will review your application and contact you via WhatsApp/Email.');
    }

    public function storeInternational(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'competition_category_id' => 'required|exists:competition_categories,id',
            'student_id_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'formal_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'youtube_url' => 'nullable|url|max:500',
        ]);

        $validated['registration_type'] = 'international';

        if ($request->hasFile('student_id_document')) {
            $validated['student_id_document'] = $request->file('student_id_document')
                ->store('registrations/id-documents', 'public');
        }

        if ($request->hasFile('formal_photo')) {
            $validated['formal_photo'] = $request->file('formal_photo')
                ->store('registrations/formal-photos', 'public');
        }

        Registration::create($validated);

        return redirect()->route('registration.international')
            ->with('success', 'Application submitted successfully! We will review your submission and contact you via WhatsApp/Email.');
    }
}
