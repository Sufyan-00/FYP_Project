<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestModeController extends Controller
{
    /**
     * Demo account credentials for each role.
     * These are seeded by GuestModeSeeder.
     */
    private const DEMO_ACCOUNTS = [
        'student'    => 'demo.student@fyp.demo',
        'supervisor' => 'demo.supervisor@fyp.demo',
        'admin'      => 'demo.admin@fyp.demo',
    ];

    /**
     * Auto-login as the demo account for the requested role.
     */
    public function login(Request $request, string $role): RedirectResponse
    {
        if (! array_key_exists($role, self::DEMO_ACCOUNTS)) {
            abort(404);
        }

        // If already authenticated, log out first so demo session is clean.
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $demoEmail = self::DEMO_ACCOUNTS[$role];

        $user = User::where('email', $demoEmail)->first();

        if (! $user) {
            return redirect()
                ->route('welcome')
                ->with('error', 'Demo account not available. Please run the GuestModeSeeder first (php artisan db:seed --class=GuestModeSeeder).');
        }

        // Log in without password validation (demo-only backdoor).
        Auth::login($user, remember: false);
        $request->session()->regenerate();

        // Mark this session as a guest/demo session so views can adapt.
        $request->session()->put('is_guest_demo', true);

        return match ($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            default      => redirect()->route('student.dashboard'),
        };
    }

    /**
     * End the demo session and return to the welcome page.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Demo session ended. Create a real account to get full access!');
    }
}
