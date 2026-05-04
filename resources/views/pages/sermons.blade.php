@extends('layouts.app', [
    'title' => 'Sermons',
    'description' => 'Daily and weekly sermons from BFC Global Trust.',
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <a href="{{ route('resources-hub') }}" class="text-sm font-bold text-pine hover:text-ember">Back to resources</a>
                <p class="mt-5 text-sm font-bold uppercase tracking-[0.15em] text-ember">Sermons</p>
                <h1 class="mt-3 text-4xl leading-tight md:text-5xl">Daily and weekly biblical messages</h1>
                <p class="mt-4 text-base leading-8 text-slate/80 md:text-lg">
                    Browse short daily encouragements and weekly sermons for family discipleship, Christian leadership, and community transformation.
                </p>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <section>
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="text-3xl">Daily Sermons</h2>
                        <span class="rounded-full bg-mist px-4 py-2 text-xs font-bold uppercase tracking-[0.12em] text-pine">Daily</span>
                    </div>
                    <div class="grid gap-4">
                        @forelse ($dailySermons as $sermon)
                            @include('pages.partials.sermon-card', ['sermon' => $sermon])
                        @empty
                            <p class="rounded-lg border border-sand bg-white p-5 text-slate/75">No daily sermons have been added yet.</p>
                        @endforelse
                    </div>
                </section>

                <section>
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <h2 class="text-3xl">Weekly Sermons</h2>
                        <span class="rounded-full bg-ember px-4 py-2 text-xs font-bold uppercase tracking-[0.12em] text-white">Weekly</span>
                    </div>
                    <div class="grid gap-4">
                        @forelse ($weeklySermons as $sermon)
                            @include('pages.partials.sermon-card', ['sermon' => $sermon])
                        @empty
                            <p class="rounded-lg border border-sand bg-white p-5 text-slate/75">No weekly sermons have been added yet.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
