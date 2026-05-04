<?php

namespace App\Http\Controllers;

use App\Mail\VolunteerApplicationSubmitted;
use App\Models\ContactInquiry;
use App\Models\Donation;
use App\Models\NewsletterSubscription;
use App\Models\PartnershipInquiry;
use App\Models\SupportInquiry;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        ContactInquiry::query()->create($validated);

        return redirect()
            ->route('contact')
            ->with('success_contact', 'Message sent successfully.');
    }

    public function storeSupport(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'household_size' => ['nullable', 'integer', 'min:1', 'max:99'],
            'preferred_contact' => ['nullable', 'string', 'max:120'],
            'needs' => ['required', 'string', 'max:4000'],
        ]);

        SupportInquiry::query()->create($validated);

        return redirect()
            ->to(route('contact'))
            ->with('success_support', 'Thank you. A care coordinator will contact you soon.');
    }

    public function storeVolunteer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'role' => ['nullable', 'string', 'max:150'],
            'availability' => ['nullable', 'string', 'max:255'],
            'interests' => ['required', 'string', 'max:3000'],
        ]);

        $application = VolunteerApplication::query()->create($validated);

        try {
            $adminEmail = config('site.organization.contact.email') ?: config('mail.from.address');
            Mail::to($adminEmail)->send(new VolunteerApplicationSubmitted($application));
        } catch (\Throwable $exception) {
            report($exception);
        }

        return redirect()
            ->to(route('get-involved') . '#volunteer-form')
            ->with('success_volunteer', 'Thank you for volunteering. We will follow up with next steps.');
    }

    public function storePartnership(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'partnership_goals' => ['required', 'string', 'max:4000'],
        ]);

        PartnershipInquiry::query()->create($validated);

        return redirect()
            ->to(route('get-involved') . '#partnership-form')
            ->with('success_partnership', 'Partnership request received. Our outreach lead will contact you shortly.');
    }

    public function storeNewsletter(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscription::query()->firstOrCreate([
            'email' => $validated['email'],
        ]);

        return redirect()
            ->back()
            ->with('success_newsletter', 'Thank you for subscribing. We are glad to stay connected.');
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'donation_type' => ['required', 'string', 'in:program,event,general'],
            'designation' => ['nullable', 'string', 'max:180'],
            'event_name' => ['nullable', 'string', 'max:180'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999.99'],
            'currency' => ['required', 'string', 'size:3'],
            'frequency' => ['required', 'string', 'in:one-time,monthly'],
            'donor_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:3000'],
            'paypal_order_id' => ['nullable', 'string', 'max:255'],
            'paypal_payer_id' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:pending,approved,completed'],
        ]);

        $donation = Donation::query()->create([
            ...$validated,
            'status' => $validated['status'] ?? 'pending',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Donation recorded successfully.',
                'donation_id' => $donation->id,
            ]);
        }

        return redirect()
            ->route('donate')
            ->with('success_donation', 'Thank you. Your donation details were received.');
    }
}
