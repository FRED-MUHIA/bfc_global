@extends('layouts.app', [
    'title' => 'Page Not Found',
    'description' => 'The page you requested could not be found.',
])

@section('content')
    <section class="container-base py-24">
        <p class="text-sm font-bold uppercase tracking-[0.16em] text-ember">404</p>
        <h1 class="mt-3 text-4xl md:text-5xl">Page Not Found</h1>
        <p class="mt-4 max-w-xl text-slate/80">
            The page you are trying to reach does not exist or may have been moved.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                Back to Home
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center text-sm font-semibold text-pine hover:text-ember">
                Contact support →
            </a>
        </div>
    </section>
@endsection
