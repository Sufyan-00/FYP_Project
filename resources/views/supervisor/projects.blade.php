<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Active Projects') }}
            </h2>
            {{-- Link to the new history page --}}
            <a href="{{ route('supervisor.history') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                View Project History &rarr;
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($projects as $project)
                            <li class="py-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium">{{ $project->title }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Student: {{ $project->student->name }}</p>
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @if ($project->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending Approval
                                            </span>
                                            {{-- Approval/Rejection actions can be added here --}}
                                        @elseif ($project->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-end space-x-3">
                                    @if ($project->status == 'pending')
                                        {{-- Add your approve/reject buttons/forms here if they aren't already --}}
                                    @elseif ($project->status == 'approved')
                                        {{-- This is the new button --}}
                                        <form action="{{ route('supervisor.projects.complete', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this project as complete? It will be moved to your history.');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">
                                                Mark as Complete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500 dark:text-gray-400">
                                You have no active projects.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>