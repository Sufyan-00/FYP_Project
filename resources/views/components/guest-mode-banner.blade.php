{{--
    Guest Mode Banner Component
    ===========================
    Shown to demo users across all dashboard pages.
    Uses inline style for the gradient so it works even before
    Vite rebuilds (Tailwind purges new classes on first load).
--}}

@if(session('is_guest_demo'))
<div
    x-data="{ visible: true }"
    x-show="visible"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="relative z-50 w-full"
    style="display: block;"
    role="alert"
    aria-label="Demo mode active"
>
    {{-- Gradient bar — inline style guarantees colour even before Vite rebuild --}}
    <div style="background: linear-gradient(to right, #f59e0b, #f97316, #f43f5e);"
         class="text-white px-4 py-2.5 shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">

            {{-- Left: label + message --}}
            <div class="flex items-center gap-2 text-sm font-medium">

                {{-- "Demo Mode" pill --}}
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold tracking-wide uppercase"
                      style="background: rgba(255,255,255,0.25);">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd"
                              d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                              clip-rule="evenodd"/>
                    </svg>
                    Demo Mode
                </span>

                <span class="hidden sm:inline" style="opacity:0.92;">
                    You are exploring as
                    <strong>{{ auth()->user()->name }}</strong>
                    ({{ ucfirst(auth()->user()->role) }}).
                    Some actions are view-only.
                </span>
                <span class="sm:hidden" style="opacity:0.92;">
                    Exploring as {{ auth()->user()->name }}
                </span>
            </div>

            {{-- Right: CTAs --}}
            <div class="flex items-center gap-3 flex-shrink-0">

                <a href="{{ route('guest.logout') }}"
                   class="text-xs font-semibold transition"
                   style="text-decoration:underline; opacity:0.92;"
                   onmouseover="this.style.opacity='1'"
                   onmouseout="this.style.opacity='0.92'">
                    Sign In / Register
                </a>

                <span style="opacity:0.4;">|</span>

                <a href="{{ route('guest.logout') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition"
                   style="background: rgba(255,255,255,0.22);"
                   onmouseover="this.style.background='rgba(255,255,255,0.35)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.22)'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Exit Demo
                </a>

                {{-- Dismiss / hide button --}}
                <button @click="visible = false"
                        class="rounded transition"
                        style="padding: 2px; background: transparent;"
                        onmouseover="this.style.background='rgba(255,255,255,0.22)'"
                        onmouseout="this.style.background='transparent'"
                        aria-label="Dismiss banner">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- "Blocked action" flash — shown when a write action is intercepted --}}
    @if(session('guest_blocked'))
    <div class="text-white text-sm px-4 py-2 text-center font-medium"
         style="background: #e11d48;"
         role="alert">
        🔒 {{ session('guest_blocked') }}
        <a href="{{ route('welcome') }}"
           class="font-semibold"
           style="text-decoration:underline; margin-left:0.5rem;">
            Sign in →
        </a>
    </div>
    @endif
</div>
@endif
