<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! hash_equals((string) config('site.admin.username'), $validated['username'])) {
            return back()
                ->withErrors(['username' => 'The admin username is incorrect.'])
                ->onlyInput('username');
        }

        $configuredPassword = (string) config('site.admin.password');
        $matches = str_starts_with($configuredPassword, '$2y$') || str_starts_with($configuredPassword, '$argon')
            ? Hash::check($validated['password'], $configuredPassword)
            : hash_equals($configuredPassword, $validated['password']);

        if (! $matches) {
            return back()
                ->withErrors(['password' => 'The admin password is incorrect.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Signed out.');
    }
}
