@extends('layouts.admin', ['title' => 'Admin Login'])

@section('content')
    <section class="mx-auto max-w-md rounded-lg border border-sand bg-white p-6 shadow-soft">
        <h1 class="text-3xl">Admin Login</h1>
        <p class="mt-2 text-sm text-slate/75">Sign in to edit website pages and publish content.</p>

        <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 grid gap-4">
            @csrf
            <label class="grid gap-2">
                <span class="text-sm font-bold text-pine">Username</span>
                <input name="username" value="{{ old('username') }}" class="field-input" required autofocus>
                @error('username')
                    <span class="text-sm font-semibold text-red-700">{{ $message }}</span>
                @enderror
            </label>

            <label class="grid gap-2">
                <span class="text-sm font-bold text-pine">Password</span>
                <input type="password" name="password" class="field-input" required>
                @error('password')
                    <span class="text-sm font-semibold text-red-700">{{ $message }}</span>
                @enderror
            </label>

            <button type="submit" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">
                Sign In
            </button>
        </form>
    </section>
@endsection
