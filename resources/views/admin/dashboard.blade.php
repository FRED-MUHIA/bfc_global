@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-4xl">Dashboard</h1>
            <p class="mt-2 text-slate/75">Manage page content and publish updates to the public site.</p>
        </div>
    </div>

    <section class="mt-7 rounded-lg border {{ $maintenanceEnabled ? 'border-ember/50 bg-ember/10' : 'border-sand bg-white' }} p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-2xl">Maintenance Mode</h2>
                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $maintenanceEnabled ? 'bg-ember text-white' : 'bg-mist text-pine' }}">
                        {{ $maintenanceEnabled ? 'On' : 'Off' }}
                    </span>
                </div>
                <p class="mt-1 text-sm text-slate/70">
                    {{ $maintenanceEnabled ? 'Public visitors see the maintenance page. Logged-in admins can still browse and edit the site.' : 'The public site is currently available to visitors.' }}
                </p>
            </div>
            <form method="POST" action="{{ route('admin.maintenance.toggle') }}">
                @csrf
                <button type="submit" class="rounded-full {{ $maintenanceEnabled ? 'bg-slate hover:bg-slate/90' : 'bg-ember hover:bg-ember/90' }} px-5 py-3 text-sm font-bold text-white">
                    Turn Maintenance {{ $maintenanceEnabled ? 'Off' : 'On' }}
                </button>
            </form>
        </div>
    </section>

    <section class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(8.75rem,1fr))]">
        <div class="min-h-32 rounded-lg border border-sand bg-white p-4">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Contacts</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $contactCount }}</p>
        </div>
        <div class="min-h-32 rounded-lg border border-sand bg-white p-4">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Donations</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $donationCount }}</p>
        </div>
        <a href="{{ route('admin.event-registrations.index') }}" class="min-h-32 rounded-lg border border-sand bg-white p-4 transition hover:bg-mist/40">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Event Signups</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $eventRegistrationCount }}</p>
        </a>
        <a href="{{ route('admin.program-registrations.index') }}" class="min-h-32 rounded-lg border border-sand bg-white p-4 transition hover:bg-mist/40">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Program Signups</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $programRegistrationCount }}</p>
        </a>
        <a href="{{ route('admin.emails.index') }}" class="min-h-32 rounded-lg border border-sand bg-white p-4 transition hover:bg-mist/40">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Emails</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $newsletterCount }}</p>
        </a>
        <a href="{{ route('admin.media.index') }}" class="min-h-32 rounded-lg border border-sand bg-white p-4 transition hover:bg-mist/40">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Media</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $mediaCount }}</p>
        </a>
        <a href="{{ route('admin.blog.index') }}" class="min-h-32 rounded-lg border border-sand bg-white p-4 transition hover:bg-mist/40">
            <p class="text-xs font-bold uppercase tracking-[0.08em] text-ember">Blogs</p>
            <p class="mt-2 text-3xl font-bold text-pine">{{ $blogCount }}</p>
        </a>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-6 lg:grid-cols-[1fr_1.1fr]">
            <div>
                <h2 class="text-2xl">Quick Image Upload</h2>
                <p class="mt-1 text-sm text-slate/70">Upload a dashboard image and copy the generated link for programs, events, page builders, or branding.</p>

                @if (session('uploaded_media_url'))
                    <div class="mt-4 rounded-lg border border-sage/30 bg-mist p-3">
                        <p class="text-xs font-bold uppercase tracking-[0.1em] text-pine">Uploaded Link</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <input readonly value="{{ session('uploaded_media_url') }}" class="min-w-0 flex-1 rounded-lg border border-sand bg-white px-3 py-2 text-xs text-slate" data-dashboard-upload-url>
                            <button type="button" class="rounded-full bg-pine px-4 py-2 text-xs font-bold text-white hover:bg-sage" data-copy-dashboard-upload="{{ session('uploaded_media_url') }}">Copy</button>
                        </div>
                    </div>
                @endif

                @if ($errors->has('media'))
                    <p class="mt-3 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-800">{{ $errors->first('media') }}</p>
                @endif

                <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mt-5 grid gap-4">
                    @csrf
                    <input type="hidden" name="return_to" value="dashboard">
                    <input type="hidden" name="image_only" value="1">
                    <label class="grid gap-2">
                        <span class="text-sm font-bold text-pine">Image Name</span>
                        <input name="name" value="{{ old('name') }}" class="field-input" placeholder="BUILD - Campus Discipleship">
                    </label>
                    <label class="grid gap-2">
                        <span class="text-sm font-bold text-pine">Image File</span>
                        <input type="file" name="media" accept="image/*" class="block w-full rounded-lg border border-sand bg-white px-4 py-3 text-sm" required>
                    </label>
                    <button type="submit" class="w-fit rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Upload Image</button>
                    <p class="text-xs text-slate/60">JPG, PNG, WebP, GIF, or SVG. Maximum file size: 5 MB.</p>
                </form>
            </div>

            <div>
                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                    <h3 class="text-xl">Latest Images</h3>
                    <a href="{{ route('admin.media.index') }}" class="text-sm font-bold text-pine hover:text-ember">View Media Library</a>
                </div>
                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($latestMediaImages as $asset)
                        @php($assetUrl = url($asset->url))
                        <article class="overflow-hidden rounded-lg border border-sand bg-cream">
                            <img src="{{ $asset->url }}" alt="{{ $asset->name }}" class="h-32 w-full object-cover" loading="lazy" decoding="async">
                            <div class="p-3">
                                <p class="truncate text-sm font-bold text-pine">{{ $asset->name }}</p>
                                <button type="button" class="mt-2 rounded-full border border-sand bg-white px-3 py-1.5 text-xs font-bold text-slate hover:bg-mist" data-copy-dashboard-upload="{{ $assetUrl }}">Copy Link</button>
                            </div>
                        </article>
                    @empty
                        <p class="rounded-lg border border-sand bg-cream p-4 text-sm text-slate/70 sm:col-span-2">No images uploaded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Header and Branding</h2>
                <p class="mt-1 text-sm text-slate/70">Edit the header name, tagline, logo, and favicon used across the site.</p>
            </div>
            <a href="{{ route('admin.branding.edit') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Branding</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Emails and Broadcasting</h2>
                <p class="mt-1 text-sm text-slate/70">View subscribed emails and send small broadcasts to individuals, event registrants, subscribers, contacts, or everyone.</p>
            </div>
            <a href="{{ route('admin.emails.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Emails</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Media Library</h2>
                <p class="mt-1 text-sm text-slate/70">Upload images and files, then copy generated links for page builder content and site settings.</p>
            </div>
            <a href="{{ route('admin.media.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Media</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Blog Management</h2>
                <p class="mt-1 text-sm text-slate/70">Create and edit blog posts independently, including images, dates, categories, excerpts, and article sections.</p>
            </div>
            <a href="{{ route('admin.blog.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Blogs</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Book Shop</h2>
                <p class="mt-1 text-sm text-slate/70">Manage book products, PDF purchase links, prices, covers, and shop availability.</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Books</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Donation Management</h2>
                <p class="mt-1 text-sm text-slate/70">Edit donation form headings, giving options, preset amounts, and available donation features independently.</p>
            </div>
            <a href="{{ route('admin.donations.edit') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Donations</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Event Management</h2>
                <p class="mt-1 text-sm text-slate/70">Create, update, delete, and review events shown on the Events page.</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Manage Events</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Program Registrations</h2>
                <p class="mt-1 text-sm text-slate/70">Review program applications. Edit each program's cohorts, intake status, and custom questions in the Ministry Programs page builder.</p>
            </div>
            <a href="{{ route('admin.program-registrations.index') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">View Signups</a>
        </div>
    </section>

    <section class="mt-8 rounded-lg border border-sand bg-white p-5">
        <div class="grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="text-2xl">Page Builders</h2>
                <p class="mt-1 text-sm text-slate/70">Each page builder now includes its wired frontend content, including text, images, cards, galleries, resources, programs, and page lists.</p>
            </div>
            <a href="#admin-pages" class="rounded-full bg-ember px-5 py-3 text-sm font-bold text-white hover:bg-ember/90">Choose a Page</a>
        </div>
    </section>

    <section id="admin-pages" class="mt-8 overflow-hidden rounded-lg border border-sand bg-white">
        <div class="border-b border-sand px-5 py-4">
            <h2 class="text-2xl">Pages</h2>
        </div>
        <div class="divide-y divide-sand">
            @foreach ($pages as $page)
                <div class="grid gap-4 px-5 py-4 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-xl">{{ $page['label'] }}</h3>
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $page['is_published'] ? 'bg-mist text-pine' : 'bg-sand/60 text-slate' }}">
                                {{ $page['is_published'] ? 'Published' : 'Draft' }}
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-slate/70">
                            {{ $page['path'] }}
                            @if ($page['updated_at'])
                                <span class="mx-2">-</span> Updated {{ $page['updated_at']->diffForHumans() }}
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ url($page['path']) }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Preview</a>
                        <a href="{{ route('admin.pages.edit', $page['slug']) }}" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white hover:bg-sage">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-copy-dashboard-upload]').forEach((button) => {
            button.addEventListener('click', async () => {
                await navigator.clipboard.writeText(button.dataset.copyDashboardUpload);
                const original = button.textContent;
                button.textContent = 'Copied';
                window.setTimeout(() => {
                    button.textContent = original;
                }, 1400);
            });
        });
    </script>
@endsection
