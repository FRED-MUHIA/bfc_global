<div class="glass-panel p-6 md:p-8">
    <h3 class="text-2xl">{{ data_get($site, 'newsletter.title', 'Stay Encouraged Every Month') }}</h3>
    <p class="mt-3 text-sm text-slate/80">
        {{ data_get($site, 'newsletter.description', 'Get practical family tips, upcoming workshops, and community stories delivered to your inbox.') }}
    </p>

    <form class="mt-6 flex flex-col gap-3 sm:flex-row" method="POST" action="{{ route('forms.newsletter') }}">
        @csrf
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            placeholder="{{ data_get($site, 'newsletter.placeholder', 'Enter your email address') }}"
            class="w-full rounded-full border border-sand px-4 py-3 text-sm outline-none focus:border-sage focus:ring-2 focus:ring-sage/20"
        >
        <button type="submit" class="shrink-0 inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
            {{ data_get($site, 'newsletter.button_label', 'Subscribe') }}
        </button>
    </form>

    @if ($errors->has('email'))
        <p class="mt-3 text-sm font-semibold text-rose-700">{{ $errors->first('email') }}</p>
    @endif
    @if (session('success_newsletter'))
        <p class="mt-3 text-sm font-semibold text-sage">{{ session('success_newsletter') }}</p>
    @endif
</div>
