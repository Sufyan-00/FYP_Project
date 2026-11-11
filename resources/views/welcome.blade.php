<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="A calmer way to manage the final year project journey — for students, supervisors, and committees.">

        <title>Pulse FYP — Final Year Project Management</title>

        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="landing-page min-h-screen bg-white text-[#0f172a] antialiased">
        <div class="relative isolate">
            {{-- Header --}}
            <header class="sticky top-0 z-40 border-b border-[#e2e8f0] bg-white/85 backdrop-blur-xl">
                <div class="mx-auto flex h-[72px] max-w-6xl items-center justify-between px-6 lg:px-8">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2.5" aria-label="Pulse FYP home">
                        <img src="{{ asset('favicon.png') }}" alt="" width="32" height="32" class="h-8 w-8 rounded-full object-cover">
                        <span class="text-[15px] font-semibold tracking-tight">Pulse FYP</span>
                    </a>

                    <nav class="hidden items-center gap-9 text-[13px] font-medium text-[#475569] md:flex" aria-label="Primary">
                        <a href="#how" class="transition-colors hover:text-[#0f172a]">How it works</a>
                        <a href="#features" class="transition-colors hover:text-[#0f172a]">Features</a>
                        <a href="#roles" class="transition-colors hover:text-[#0f172a]">Roles</a>
                    </nav>

                    <a href="#roles" class="rounded-full bg-[#2563eb] px-4 py-2.5 text-[13px] font-medium text-white transition-colors hover:bg-[#1d4ed8]">
                        Get started
                    </a>
                </div>
            </header>

            <main>
                {{-- Hero --}}
                <section class="mx-auto max-w-6xl px-6 pb-20 pt-20 text-center sm:pb-24 sm:pt-28 lg:px-8">
                    <div class="animate-rise inline-flex items-center gap-2 rounded-full border border-[#dbeafe] bg-[#eff6ff] px-3.5 py-1.5 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#1d4ed8]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#2563eb]"></span>
                        Final year, finally organized
                    </div>

                    <h1 class="animate-rise mx-auto mt-7 max-w-4xl text-[clamp(2.75rem,6.5vw,4.75rem)] font-bold leading-[1.05] tracking-[-0.035em]" style="animation-delay: 80ms">
                        A calmer way to run your
                        <span class="whitespace-nowrap text-[#2563eb]">final year</span> project.
                    </h1>

                    <p class="animate-rise mx-auto mt-7 max-w-xl text-[16px] leading-8 text-[#475569] sm:text-[17px]" style="animation-delay: 160ms">
                        Pulse FYP brings ideas, reviews, deadlines, and defences into one quiet space — so everyone can focus on the work itself.
                    </p>

                    <div class="animate-rise mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row" style="animation-delay: 240ms">
                        <a href="#how" class="inline-flex items-center justify-center rounded-full border border-[#e2e8f0] px-6 py-3.5 text-[13px] font-medium text-[#334155] transition-colors hover:border-[#bfdbfe] hover:bg-[#eff6ff]">
                            See how it works
                        </a>
                    </div>

                    <p class="animate-rise mt-8 text-[11px] font-medium uppercase tracking-[0.16em] text-[#64748b]" style="animation-delay: 320ms">
                        For students &middot; Supervisors &middot; Committees
                    </p>
                </section>

                {{-- Stats --}}
                <section class="border-y border-[#e2e8f0] bg-[#e2e8f0]">
                    <div class="mx-auto grid max-w-6xl grid-cols-2 gap-px sm:grid-cols-4">
                        <div class="bg-white px-6 py-8 text-center">
                            <p class="text-3xl font-semibold tracking-tight text-[#0f172a] sm:text-4xl">60&ndash;70%</p>
                            <p class="mt-2 text-[11px] uppercase tracking-[0.14em] text-[#64748b]">Faster approvals</p>
                        </div>
                        <div class="bg-white px-6 py-8 text-center">
                            <p class="text-3xl font-semibold tracking-tight text-[#0f172a] sm:text-4xl">4 roles</p>
                            <p class="mt-2 text-[11px] uppercase tracking-[0.14em] text-[#64748b]">One shared system</p>
                        </div>
                        <div class="bg-white px-6 py-8 text-center">
                            <p class="text-3xl font-semibold tracking-tight text-[#0f172a] sm:text-4xl">100%</p>
                            <p class="mt-2 text-[11px] uppercase tracking-[0.14em] text-[#64748b]">Workflow visibility</p>
                        </div>
                        <div class="bg-white px-6 py-8 text-center">
                            <p class="text-3xl font-semibold tracking-tight text-[#0f172a] sm:text-4xl">24/7</p>
                            <p class="mt-2 text-[11px] uppercase tracking-[0.14em] text-[#64748b]">Access anywhere</p>
                        </div>
                    </div>
                </section>

                {{-- How it works --}}
                <section id="how" class="mx-auto max-w-6xl px-6 py-24 sm:py-28 lg:px-8 lg:py-32">
                    <div class="grid gap-12 lg:grid-cols-[0.85fr_1.15fr] lg:gap-20">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#2563eb]">How it works</p>
                            <h2 class="mt-4 max-w-sm text-4xl font-bold leading-[1.08] tracking-[-0.03em] sm:text-5xl">
                                From first idea to final defence.
                            </h2>
                            <p class="mt-5 max-w-sm text-[14px] leading-7 text-[#475569]">
                                One continuous thread for every decision, document, and deadline — no lost emails, no paper trails.
                            </p>
                        </div>

                        <div>
                            <div class="group grid grid-cols-[auto_1fr_auto] items-start gap-5 border-t border-[#e2e8f0] py-7 sm:gap-7">
                                <span class="text-sm font-semibold text-[#94a3b8]">01</span>
                                <div>
                                    <h3 class="text-lg font-semibold tracking-tight sm:text-xl">Shape your idea</h3>
                                    <p class="mt-2 max-w-md text-[13px] leading-6 text-[#475569]">Submit project ideas, discover supervisor interests, and get aligned from day one.</p>
                                </div>
                                <span aria-hidden="true" class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full border border-[#e2e8f0] text-[12px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&rarr;</span>
                            </div>

                            <div class="group grid grid-cols-[auto_1fr_auto] items-start gap-5 border-t border-[#e2e8f0] py-7 sm:gap-7">
                                <span class="text-sm font-semibold text-[#94a3b8]">02</span>
                                <div>
                                    <h3 class="text-lg font-semibold tracking-tight sm:text-xl">Build with confidence</h3>
                                    <p class="mt-2 max-w-md text-[13px] leading-6 text-[#475569]">Track scope reviews, revisions, and feedback from one focused dashboard.</p>
                                </div>
                                <span aria-hidden="true" class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full border border-[#e2e8f0] text-[12px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&rarr;</span>
                            </div>

                            <div class="group grid grid-cols-[auto_1fr_auto] items-start gap-5 border-y border-[#e2e8f0] py-7 sm:gap-7">
                                <span class="text-sm font-semibold text-[#94a3b8]">03</span>
                                <div>
                                    <h3 class="text-lg font-semibold tracking-tight sm:text-xl">Defend your work</h3>
                                    <p class="mt-2 max-w-md text-[13px] leading-6 text-[#475569]">Coordinate committees and schedules with conflict-free defence sessions and digital rubrics.</p>
                                </div>
                                <span aria-hidden="true" class="mt-0.5 flex h-8 w-8 items-center justify-center rounded-full border border-[#e2e8f0] text-[12px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&rarr;</span>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Features --}}
                <section id="features" class="border-y border-[#e2e8f0]">
                    <div class="mx-auto max-w-6xl px-6 py-24 sm:py-28 lg:px-8">
                        <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#2563eb]">Designed for momentum</p>
                                <h2 class="mt-4 max-w-xs text-4xl font-bold leading-[1.08] tracking-[-0.03em] sm:text-5xl">
                                    Less admin. More progress.
                                </h2>
                                <p class="mt-5 max-w-sm text-[14px] leading-7 text-[#475569]">
                                    Pulse FYP takes care of the coordination overhead, so every person can focus on the part they do best.
                                </p>
                            </div>

                            <div class="grid gap-x-10 gap-y-9 sm:grid-cols-2">
                                <div>
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#dbeafe] bg-[#eff6ff] text-[#2563eb]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="8.25"></circle>
                                            <path d="M12 7.75V12l2.75 1.75"></path>
                                        </svg>
                                    </span>
                                    <h3 class="mt-4 text-[14px] font-semibold">Live status tracking</h3>
                                    <p class="mt-1.5 text-[12px] leading-6 text-[#475569]">Know exactly where every project stands, at a glance.</p>
                                </div>

                                <div>
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#dbeafe] bg-[#eff6ff] text-[#2563eb]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect x="3.75" y="5.25" width="16.5" height="15" rx="2.5"></rect>
                                            <path d="M3.75 9.75h16.5M8.25 3.75v3M15.75 3.75v3"></path>
                                        </svg>
                                    </span>
                                    <h3 class="mt-4 text-[14px] font-semibold">Smart scheduling</h3>
                                    <p class="mt-1.5 text-[12px] leading-6 text-[#475569]">Prevent venue and committee conflicts automatically.</p>
                                </div>

                                <div>
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#dbeafe] bg-[#eff6ff] text-[#2563eb]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M6.75 3.75h7.5l3 3v13.5H6.75z"></path>
                                            <path d="M14.25 3.75v3h3M9.75 11.25h4.5M9.75 14.25h4.5"></path>
                                        </svg>
                                    </span>
                                    <h3 class="mt-4 text-[14px] font-semibold">Centralized documents</h3>
                                    <p class="mt-1.5 text-[12px] leading-6 text-[#475569]">Keep scopes, templates, and reports easy to find.</p>
                                </div>

                                <div>
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#dbeafe] bg-[#eff6ff] text-[#2563eb]">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 3.75l2.4 4.86 5.35.78-3.87 3.77.91 5.34L12 16l-4.79 2.5.91-5.34-3.87-3.77 5.35-.78z"></path>
                                        </svg>
                                    </span>
                                    <h3 class="mt-4 text-[14px] font-semibold">Fair evaluations</h3>
                                    <p class="mt-1.5 text-[12px] leading-6 text-[#475569]">Standardized rubrics bring clarity to every review.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Roles --}}
                <section id="roles" class="mx-auto max-w-6xl px-6 py-24 sm:py-28 lg:px-8 lg:py-32">
                    <div class="mx-auto max-w-xl text-center">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#2563eb]">Your workspace is ready</p>
                        <h2 class="mt-4 text-4xl font-bold leading-[1.08] tracking-[-0.03em] sm:text-5xl">Choose your way in.</h2>
                    </div>

                    <div class="mx-auto mt-12 grid max-w-5xl gap-4 md:grid-cols-3">
                        <a href="{{ route('login.role', ['role' => 'student']) }}" class="group relative rounded-2xl border border-[#e2e8f0] bg-white p-6 transition-all hover:-translate-y-0.5 hover:border-[#bfdbfe] hover:shadow-[0_18px_40px_-30px_rgba(37,99,235,0.45)]">
                            <div class="flex items-start justify-between">
                                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563eb]">Student</span>
                                <span aria-hidden="true" class="flex h-7 w-7 items-center justify-center rounded-full border border-[#e2e8f0] text-[11px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&nearr;</span>
                            </div>
                            <h3 class="mt-8 text-xl font-semibold tracking-tight">Submit &amp; track</h3>
                            <p class="mt-2 text-[12px] leading-6 text-[#475569]">Share ideas, manage your scope, and follow your progress.</p>
                        </a>

                        <a href="{{ route('login.role', ['role' => 'supervisor']) }}" class="group relative rounded-2xl border border-[#e2e8f0] bg-white p-6 transition-all hover:-translate-y-0.5 hover:border-[#bfdbfe] hover:shadow-[0_18px_40px_-30px_rgba(37,99,235,0.45)]">
                            <div class="flex items-start justify-between">
                                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563eb]">Supervisor</span>
                                <span aria-hidden="true" class="flex h-7 w-7 items-center justify-center rounded-full border border-[#e2e8f0] text-[11px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&nearr;</span>
                            </div>
                            <h3 class="mt-8 text-xl font-semibold tracking-tight">Guide &amp; review</h3>
                            <p class="mt-2 text-[12px] leading-6 text-[#475569]">Support projects, review submissions, and manage capacity.</p>
                        </a>

                        <a href="{{ route('login.role', ['role' => 'admin']) }}" class="group relative rounded-2xl border border-[#e2e8f0] bg-white p-6 transition-all hover:-translate-y-0.5 hover:border-[#bfdbfe] hover:shadow-[0_18px_40px_-30px_rgba(37,99,235,0.45)]">
                            <div class="flex items-start justify-between">
                                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2563eb]">Administrator</span>
                                <span aria-hidden="true" class="flex h-7 w-7 items-center justify-center rounded-full border border-[#e2e8f0] text-[11px] text-[#64748b] transition-colors group-hover:border-[#2563eb] group-hover:bg-[#eff6ff] group-hover:text-[#2563eb]">&nearr;</span>
                            </div>
                            <h3 class="mt-8 text-xl font-semibold tracking-tight">Orchestrate</h3>
                            <p class="mt-2 text-[12px] leading-6 text-[#475569]">Manage users, committees, phases, and reports.</p>
                        </a>
                    </div>

                    {{-- Demo --}}
                    <div class="mx-auto mt-5 flex max-w-5xl flex-col items-start justify-between gap-4 rounded-2xl border border-[#dbeafe] bg-[#eff6ff] px-6 py-5 sm:flex-row sm:items-center">
                        <div>
                            <p class="text-[13px] font-semibold">Just exploring?</p>
                            <p class="mt-0.5 text-[12px] text-[#475569]">Step into a read-only demo and see Pulse FYP from the inside.</p>
                        </div>
                        <a href="{{ route('guest.login', ['role' => 'student']) }}" class="group inline-flex items-center gap-2 rounded-full border border-[#bfdbfe] bg-white px-4 py-2 text-[12px] font-medium text-[#1d4ed8] transition-colors hover:border-[#2563eb]">
                            Try the demo
                            <span aria-hidden="true" class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                        </a>
                    </div>
                </section>

                {{-- Closing CTA --}}
                <section class="mx-auto max-w-6xl px-6 pb-24 lg:px-8">
                    <div class="relative overflow-hidden rounded-[2rem] border border-[#dbeafe] bg-[#eff6ff] px-6 py-16 text-center sm:px-14">
                        <div class="relative">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-[#2563eb]">Make progress visible</p>
                            <h2 class="mx-auto mt-4 max-w-lg text-4xl font-bold leading-[1.08] tracking-[-0.03em] text-[#0f172a] sm:text-5xl">
                                Ready when you are.
                            </h2>
                            <p class="mx-auto mt-4 max-w-md text-[13px] leading-7 text-[#475569]">
                                Explore a read-only workspace and see how Pulse FYP feels from the inside.
                            </p>
                            <div class="mt-8 flex justify-center">
                                <a href="{{ route('guest.login', ['role' => 'student']) }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#2563eb] px-6 py-3 text-[13px] font-medium text-white transition-colors hover:bg-[#1d4ed8]">
                                    Explore the demo
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="border-t border-[#e2e8f0] bg-white">
                <div class="mx-auto flex max-w-6xl flex-col gap-3 px-6 py-8 text-[11px] text-[#64748b] sm:flex-row sm:items-center sm:justify-between lg:px-8">
                    <p>&copy; {{ date('Y') }} Pulse FYP &middot; SSJ-Pulse Enterprise</p>
                    <p>Make progress visible.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
