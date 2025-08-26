<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="font-medium text-gray-900">Upcoming Defence</h3>

                    @if ($upcomingSession)
                        <div class="mt-3 text-sm text-gray-700 space-y-1">
                            <p><span class="font-semibold">Project:</span> {{ $upcomingSession->project->title }}</p>
                            <p><span class="font-semibold">Committee:</span> {{ $upcomingSession->committee->name }}</p>
                            <p><span class="font-semibold">When:</span> {{ $upcomingSession->scheduled_at->format('Y-m-d H:i') }}</p>
                            <p><span class="font-semibold">Venue:</span> {{ $upcomingSession->venue ?: 'TBA' }}</p>
                        </div>
                    @else
                        <p class="mt-3 text-gray-500">No upcoming defence scheduled yet.</p>
                    @endif
                </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Your Project</h3>
                    @if ($project)
                        <p class="mt-2 text-gray-700">
                            Title: {{ $project->title ?? 'Untitled' }} <br>
                            Status: <span class="font-semibold">{{ ucfirst($project->status) }}</span>
                        </p>
                        <div class="mt-4">
                            <a class="text-blue-600 hover:text-blue-800" href="{{ route('projects.show', $project) }}">View details</a>
                        </div>
                    @else
                        <p class="mt-2 text-gray-600">You have not created a project yet.</p>
                        <a class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                           href="{{ route('projects.create') }}">Create Project</a>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Document Templates</h3>
                    <ul class="mt-3 space-y-2">
                        @forelse ($templates as $template)
                            <li class="flex justify-between items-center p-2 border rounded-md">
                                <span>{{ $template->name }}</span>
                                <a class="text-blue-600 hover:text-blue-800" href="{{ route('templates.download', $template) }}">Download</a>
                            </li>
                        @empty
                            <li class="text-gray-500">No templates available yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>