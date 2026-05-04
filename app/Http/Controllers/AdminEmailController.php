<?php

namespace App\Http\Controllers;

use App\Mail\BulkBroadcastMail;
use App\Models\ContactInquiry;
use App\Models\EmailBroadcast;
use App\Models\EventRegistration;
use App\Models\NewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminEmailController extends Controller
{
    public function index(): View
    {
        return view('admin.emails.index', [
            'subscriptions' => NewsletterSubscription::query()->latest()->paginate(15, ['*'], 'subscribers'),
            'broadcasts' => EmailBroadcast::query()->latest()->limit(12)->get(),
            'subscriberCount' => NewsletterSubscription::query()->count(),
            'eventEmailCount' => EventRegistration::query()->distinct('email')->count('email'),
            'contactEmailCount' => ContactInquiry::query()->distinct('email')->count('email'),
            'events' => EventRegistration::query()
                ->select('event_slug', 'event_title')
                ->distinct()
                ->orderBy('event_title')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:individual,event,monthly_encouragement,news_update,alert'],
            'audience' => ['required', 'string', 'in:manual,subscribers,event_registrants,contacts,all'],
            'event_slug' => ['nullable', 'string', 'max:180'],
            'manual_emails' => ['nullable', 'string', 'max:8000'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:12000'],
        ]);

        $recipients = $this->recipients($validated);

        if ($recipients->isEmpty()) {
            return back()
                ->withErrors(['audience' => 'No email addresses were found for that audience.'])
                ->withInput();
        }

        $broadcast = EmailBroadcast::query()->create([
            'type' => $validated['type'],
            'audience' => $validated['audience'],
            'event_slug' => $validated['event_slug'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'manual_emails' => $this->parseManualEmails($validated['manual_emails'] ?? '')->values()->all(),
            'recipient_count' => $recipients->count(),
            'sent_at' => now(),
        ]);

        $fromAddress = config('mail.from.address');

        $recipients
            ->chunk(50)
            ->each(function (Collection $chunk) use ($broadcast, $fromAddress): void {
                Mail::to($fromAddress)
                    ->bcc($chunk->values()->all())
                    ->send(new BulkBroadcastMail(
                        $broadcast->subject,
                        $broadcast->message,
                        $broadcast->type,
                    ));
            });

        return redirect()
            ->route('admin.emails.index')
            ->with('status', 'Email broadcast sent to ' . $recipients->count() . ' recipient(s).');
    }

    private function recipients(array $validated): Collection
    {
        $manual = $this->parseManualEmails($validated['manual_emails'] ?? '');

        $emails = match ($validated['audience']) {
            'manual' => $manual,
            'subscribers' => NewsletterSubscription::query()->pluck('email'),
            'event_registrants' => EventRegistration::query()
                ->when($validated['event_slug'] ?? null, fn ($query, $eventSlug) => $query->where('event_slug', $eventSlug))
                ->pluck('email'),
            'contacts' => ContactInquiry::query()->pluck('email'),
            'all' => collect()
                ->merge($manual)
                ->merge(NewsletterSubscription::query()->pluck('email'))
                ->merge(EventRegistration::query()->pluck('email'))
                ->merge(ContactInquiry::query()->pluck('email')),
        };

        return collect($emails)
            ->map(fn ($email) => strtolower(trim((string) $email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();
    }

    private function parseManualEmails(string $emails): Collection
    {
        return collect(preg_split('/[\s,;]+/', $emails) ?: [])
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();
    }
}
