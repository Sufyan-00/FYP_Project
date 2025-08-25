<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Approval Dashboard') }}
        </h2>
        <a href="{{ route('supervisor.history') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        View Project History &rarr;
        </a>

    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- 👇 ADD THIS ERROR MESSAGE BLOCK 👇 --}}
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        {{-- 👆 END ERROR MESSAGE BLOCK 👆 --}}

        {{-- Success Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Project Submissions</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($projects as $project)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $project->student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $project->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if ($project->status == 'approved') bg-green-100 text-green-800
                                                @elseif ($project->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif ($project->status == 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                        </td>
                                        {{-- Inside the @forelse loop --}}

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if ($project->status == 'pending')
                                                <div x-data="{ showRejectModal: false }" class="flex items-center gap-4">
                                                    {{-- Approve Form --}}
                                                    <form method="POST" action="{{ route('supervisor.projects.approve', $project) }}" class="inline-block">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Approve</button>
                                                    </form>

                                                    {{-- Reject Button --}}
                                                    <button @click="showRejectModal = true" class="text-red-600 hover:text-red-900">Reject</button>

                                                    <!-- Reject Modal -->
                                                    <div x-show="showRejectModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.away="showRejectModal = false" style="display: none;">
                                                        <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md">
                                                            <h3 class="text-lg font-bold mb-4">Provide Rejection Feedback</h3>
                                                            <form method="POST" action="{{ route('supervisor.projects.reject', $project) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <textarea name="rejection_reason" class="w-full border-gray-300 rounded-md shadow-sm" rows="4" placeholder="Please provide a clear reason for rejection..." required minlength="10"></textarea>
                                                                <div class="mt-4 flex justify-end gap-4">
                                                                    <button type="button" @click="showRejectModal = false" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Cancel</button>
                                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Submit Rejection</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($project->status == 'approved')
                                                <form action="{{ route('supervisor.projects.complete', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this project as complete? It will be moved to your history.');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-200">
                                                        Mark as Complete
                                                    </button>
                                                </form>
                                                @if ($project->latestScopeDocument)
                                                    <a href="{{ route('scope.document.download', $project->latestScopeDocument) }}" class="text-indigo-600 hover:text-indigo-900">Download Scope</a>
                                                @else
                                                    <span class="text-gray-500">Awaiting Document</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500 capitalize">{{ $project->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            You have no project submissions to review at this time.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>