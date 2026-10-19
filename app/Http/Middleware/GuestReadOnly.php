<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware that intercepts write/mutating actions from demo (guest) accounts.
 *
 * When a demo user tries to perform a restricted action, they get a JSON or
 * redirect response explaining that a real account is required.
 *
 * Usage in routes:  ->middleware('guest.readonly')
 */
class GuestReadOnly
{
    /**
     * HTTP methods that are considered read-only (always allowed).
     */
    private const SAFE_METHODS = ['GET', 'HEAD', 'OPTIONS'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isGuestSession($request) && ! $this->isSafeMethod($request)) {
            $message = '🔒 This action requires a real account. '
                . 'You\'re currently in demo mode. Please sign in with your credentials.';

            if ($request->expectsJson()) {
                return response()->json(['error' => $message], 403);
            }

            return back()
                ->with('guest_blocked', $message);
        }

        return $next($request);
    }

    private function isGuestSession(Request $request): bool
    {
        if (! Auth::check()) {
            return false;
        }

        return $request->session()->get('is_guest_demo', false) === true;
    }

    private function isSafeMethod(Request $request): bool
    {
        return in_array(strtoupper($request->method()), self::SAFE_METHODS);
    }
}
