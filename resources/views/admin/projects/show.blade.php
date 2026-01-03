<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Project Details
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.projects.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Back to Projects
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Project Information -->
            <div class="bg-white dark: bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Project Information</h3>
                    
                    <div class="grid grid-cols-1 md: grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark: text-gray-400">Title</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->title }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @switch($project->status)
                                        @case('approved') bg-green-100 text-green-800 @break
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('rejected') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Student</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $project->student->name }}
                                <br><span class="text-xs text-gray-500">{{ $project->student->email }}</span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Supervisor</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if($project->supervisor)
                                    {{ $project->supervisor->name }}
                                    <br><span class="text-xs text-gray-500">{{ $project->supervisor->email }}</span>
                                @else
                                    <span class="text-gray-500">Not assigned</span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->created_at->format('M j, Y @ H:i') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->updated_at->format('M j, Y @ H: i') }}</dd>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <dt class="text-sm font-medium text-gray-500 dark: text-gray-400">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $project->description }}</dd>
                    </div>
                </div>
            </div>

            <!-- Defence Sessions -->
            @if($project->defenceSessions->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Defence Sessions</h3>
                        
                        <div class="space-y-3">
                            @foreach($project->defenceSessions as $session)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $session->committee->name ??  'No Committee' }}</p>
                                            <p class="text-sm text-gray-600 dark: text-gray-400">
                                                Scheduled: {{ $session->scheduled_at->format('M j, Y @ H:i') }}
                                            </p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @switch($session->status)
                                                @case('scheduled') bg-blue-100 text-blue-800 @break
                                                @case('completed') bg-green-100 text-green-800 @break
                                                @case('cancelled') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            @if($project->status === 'pending')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                        
                        <div class="flex gap-4">
                            <form action="{{ route('admin.projects.update-status', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" 
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
                                        onclick="return confirm('Approve this project?')">
                                    Approve Project
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.projects.update-status', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" 
                                        class="bg-red-500 text-white px-4 py-2 rounded hover: bg-red-600"
                                        onclick="return confirm('Reject this project?')">
                                    Reject Project
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>