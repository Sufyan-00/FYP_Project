<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Projects') }}
            </h2>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse ($projects as $project)
                            <li class="py-4">
                                <div class="flex space-x-3">
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-medium">{{ $project->title }}</h3>
                                            <p class="text-sm text-gray-500">
                                                Supervisor: {{ $project->supervisor->name ?? 'Not Assigned' }}
                                            </p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ $project->description }}
                                        </p>
                                        
                                        @if ($project->status == 'rejected' && $project->rejection_reason)
                                            <div class="mt-3 bg-red-50 border border-red-200 text-red-800 text-sm p-3 rounded-md">
                                                <p><strong class="font-semibold">Supervisor Feedback:</strong> {{ $project->rejection_reason }}</p>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between pt-2">
                                            <div>
                                                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ 
                                                    $project->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                                    ($project->status == 'rejected' ? 'bg-red-100 text-red-800' : 
                                                    'bg-yellow-100 text-yellow-800') 
                                                }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </div>
                                            <div class="text-sm font-medium">
                                                @if ($project->status == 'approved')
                                                    @if ($project->latestScopeDocument)
                                                        {{-- This now points to the unified download route --}}
                                                        <a href="{{ route('scope.document.download', $project->latestScopeDocument) }}" class="text-green-600 hover:text-green-900">View Document</a>
                                                    @else
                                                        <a href="{{ route('projects.scope.create', $project) }}" class="text-indigo-600 hover:text-indigo-900">Upload Scope</a>
                                                    @endif
                                                @elseif ($project->status == 'rejected')
                                                    <a href="{{ route('projects.edit', $project) }}" class="text-blue-600 hover:text-blue-900">Edit & Resubmit</a>
                                                @elseif ($project->status == 'completed')
                                                    <span class="text-gray-500 cursor-not-allowed">Project has been marked completed.</span>
                                                @else
                                                    <span class="text-gray-500 cursor-not-allowed">Awaiting Approval</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4">
                                <p class="text-center text-gray-500">You have not created any projects yet.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>