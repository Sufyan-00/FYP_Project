<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- This will be dynamic later based on the authenticated user's role --}}
                    @if (request()->get('role') == 'student' || !request()->get('role'))
                        {{-- Student Dashboard View --}}
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Student Dashboard
                            </h3>
                            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Project Status</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">Approved</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Upcoming Deadline</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">Scope Document</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Notifications</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">3 Unread</dd>
                                </div>
                            </dl>
                        </div>
                    
                    @elseif (request()->get('role') == 'supervisor')
                        {{-- Supervisor Dashboard View --}}
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Supervisor Dashboard
                            </h3>
                            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Ideas</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">4</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Active Projects</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">7</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Available Slots</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">1</dd>
                                </div>
                            </dl>
                        </div>

                    @elseif (request()->get('role') == 'admin')
                        {{-- Admin Dashboard View --}}
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Administrator Dashboard
                            </h3>
                            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Students</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">150</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Supervisors</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">25</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Projects</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">12</dd>
                                </div>
                                <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 truncate">Scheduled Defenses</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">8</dd>
                                </div>
                            </dl>
                        </div>
                    @endif {{-- THIS WAS THE MISSING LINE --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>