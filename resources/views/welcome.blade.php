<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            FYP Management System
        </h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Select your role to continue
        </p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-200 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        <!-- Student Login Card -->
        <a href="{{ route('login.role', ['role' => 'student']) }}" 
           id="student-login-btn"
           class="block w-full p-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-lg shadow-lg transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-lg font-semibold text-white">Student</p>
                    <p class="text-sm text-blue-100">Access your projects &amp; submissions</p>
                </div>
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Supervisor Login Card -->
        <a href="{{ route('login.role', ['role' => 'supervisor']) }}" 
           id="supervisor-login-btn"
           class="block w-full p-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 rounded-lg shadow-lg transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-lg font-semibold text-white">Supervisor</p>
                    <p class="text-sm text-emerald-100">Manage students &amp; review projects</p>
                </div>
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Admin Login Card -->
        <a href="{{ route('login.role', ['role' => 'admin']) }}" 
           id="admin-login-btn"
           class="block w-full p-4 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-lg shadow-lg transform hover:scale-[1.02] transition-all duration-200">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-lg font-semibold text-white">Administrator</p>
                    <p class="text-sm text-purple-100">System administration &amp; management</p>
                </div>
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </a>
    </div>

    {{-- ============================================================
         GUEST / DEMO MODE SECTION
         ============================================================ --}}
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
        <div class="text-center mb-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300 text-xs font-semibold rounded-full uppercase tracking-wide">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                Try a Demo
            </span>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Explore the system without creating an account. Actions that modify data will prompt you to sign in.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

            {{-- Demo: Student --}}
            <a href="{{ route('guest.login', ['role' => 'student']) }}"
               id="demo-student-btn"
               class="group flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-dashed border-blue-300 dark:border-blue-700 hover:border-blue-500 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">Student View</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Projects &amp; submissions</div>
                </div>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-400 group-hover:underline">
                    Try as Student →
                </span>
            </a>

            {{-- Demo: Supervisor --}}
            <a href="{{ route('guest.login', ['role' => 'supervisor']) }}"
               id="demo-supervisor-btn"
               class="group flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-dashed border-emerald-300 dark:border-emerald-700 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200">
                <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">Supervisor View</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Review &amp; approvals</div>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 group-hover:underline">
                    Try as Supervisor →
                </span>
            </a>

            {{-- Demo: Admin --}}
            <a href="{{ route('guest.login', ['role' => 'admin']) }}"
               id="demo-admin-btn"
               class="group flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-dashed border-purple-300 dark:border-purple-700 hover:border-purple-500 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-all duration-200">
                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="text-center">
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">Admin View</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">System management</div>
                </div>
                <span class="text-xs font-medium text-purple-600 dark:text-purple-400 group-hover:underline">
                    Try as Admin →
                </span>
            </a>
        </div>

        <p class="mt-3 text-center text-xs text-gray-400 dark:text-gray-500">
            Demo sessions are read-only. No data will be modified.
        </p>
    </div>
</x-guest-layout>
