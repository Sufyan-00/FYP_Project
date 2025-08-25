<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Supervisor Directory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Available Supervisors</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($supervisors as $supervisor)
                            {{-- This check prevents the page from crashing if a supervisor somehow has no profile --}}
                            @if ($supervisor->supervisorProfile)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">{{ $supervisor->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $supervisor->email }}</p>
                                    
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Research Interests:</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $supervisor->supervisorProfile->research_interests ?? 'Not specified' }}
                                        </p>
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Available Slots:</p>
                                        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                            {{-- This is the line that was causing the error. It's now safe. --}}
                                            {{ $supervisor->supervisorProfile->available_slots }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">No supervisors are available at this time.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>