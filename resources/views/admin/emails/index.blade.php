@extends('layouts.admin', ['title' => 'Email Broadcasts'])

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-ember">Back to dashboard</a>
            <h1 class="mt-3 text-4xl">Emails and Broadcasting</h1>
            <p class="mt-2 max-w-3xl text-slate/75">View subscribed emails and send small broadcasts for individuals, event updates, monthly encouragements, news, and alerts.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <p class="font-bold">Please fix these fields:</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-lg border border-sand bg-white p-5">
            <p class="text-sm font-bold uppercase tracking-[0.12em] text-ember">Subscribers</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $subscriberCount }}</p>
        </div>
        <div class="rounded-lg border border-sand bg-white p-5">
            <p class="text-sm font-bold uppercase tracking-[0.12em] text-ember">Event Emails</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $eventEmailCount }}</p>
        </div>
        <div class="rounded-lg border border-sand bg-white p-5">
            <p class="text-sm font-bold uppercase tracking-[0.12em] text-ember">Contact Emails</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $contactEmailCount }}</p>
        </div>
    </section>

    <form method="POST" action="{{ route('admin.emails.store') }}" class="mt-8 rounded-lg border border-sand bg-white p-6">
        @csrf
        <h2 class="text-2xl">Send Broadcast</h2>

        <div class="mt-5 grid gap-5 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-bold text-pine">Email Type</span>
                <select name="type" class="field-input mt-2">
                    <option value="monthly_encouragement" @selected(old('type') === 'monthly_encouragement')>Monthly Encouragement</option>
                    <option value="news_update" @selected(old('type') === 'news_update')>News and Updates</option>
                    <option value="event" @selected(old('type') === 'event')>Event Email</option>
                    <option value="alert" @selected(old('type') === 'alert')>Alert</option>
                    <option value="individual" @selected(old('type') === 'individual')>Individual Email</option>
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Audience</span>
                <select name="audience" class="field-input mt-2">
                    <option value="subscribers" @selected(old('audience') === 'subscribers')>Newsletter Subscribers</option>
                    <option value="event_registrants" @selected(old('audience') === 'event_registrants')>Event Registrants</option>
                    <option value="contacts" @selected(old('audience') === 'contacts')>Contact Form Emails</option>
                    <option value="manual" @selected(old('audience') === 'manual')>Manual Individual Emails</option>
                    <option value="all" @selected(old('audience') === 'all')>All Emails</option>
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Event Filter</span>
                <select name="event_slug" class="field-input mt-2">
                    <option value="">All event registrations</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->event_slug }}" @selected(old('event_slug') === $event->event_slug)>{{ $event->event_title }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Subject</span>
                <input name="subject" value="{{ old('subject') }}" class="field-input mt-2" required>
            </label>
        </div>

        <label class="mt-5 block">
            <span class="text-sm font-bold text-pine">Manual Emails</span>
            <textarea name="manual_emails" rows="3" class="field-input mt-2" placeholder="One or many emails, separated by commas, spaces, or new lines">{{ old('manual_emails') }}</textarea>
        </label>

        <label class="mt-5 block">
            <span class="text-sm font-bold text-pine">Message</span>
            <textarea name="message" rows="8" class="field-input mt-2" required>{{ old('message') }}</textarea>
        </label>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Send Broadcast</button>
        </div>
    </form>

    <section class="mt-8 grid gap-6 lg:grid-cols-[1fr_1fr]">
        <div class="overflow-hidden rounded-lg border border-sand bg-white">
            <div class="border-b border-sand px-5 py-4">
                <h2 class="text-2xl">Subscribed Emails</h2>
            </div>
            <div class="divide-y divide-sand">
                @forelse ($subscriptions as $subscription)
                    <div class="px-5 py-3">
                        <p class="font-bold text-pine">{{ $subscription->email }}</p>
                        <p class="text-xs text-slate/65">Joined {{ $subscription->created_at->format('M d, Y') }}</p>
                    </div>
                @empty
                    <p class="px-5 py-4 text-slate/70">No newsletter subscribers yet.</p>
                @endforelse
            </div>
            <div class="px-5 py-4">
                {{ $subscriptions->links() }}
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-sand bg-white">
            <div class="border-b border-sand px-5 py-4">
                <h2 class="text-2xl">Recent Broadcasts</h2>
            </div>
            <div class="divide-y divide-sand">
                @forelse ($broadcasts as $broadcast)
                    <div class="px-5 py-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <p class="font-bold text-pine">{{ $broadcast->subject }}</p>
                            <span class="rounded-full bg-mist px-3 py-1 text-xs font-bold uppercase text-pine">{{ str($broadcast->type)->replace('_', ' ') }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate/70">{{ $broadcast->recipient_count }} recipient(s) - {{ $broadcast->sent_at?->format('M d, Y g:i A') }}</p>
                    </div>
                @empty
                    <p class="px-5 py-4 text-slate/70">No broadcasts sent yet.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
