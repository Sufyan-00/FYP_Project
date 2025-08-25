<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Supervisor Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Active Projects</h3>
                        <div class="text-sm text-gray-600">
                            Available slots: <span class="font-semibold">{{ $availableSlots ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="mt-3 divide-y">
                        @forelse ($activeProjects as $p)
                            <div class="py-2 flex justify-between items-center">
                                <div>
                                    <div class="font-medium">{{ $p->title ?? 'Untitled' }}</div>
                                    <div class="text-sm text-gray-500">
                                        Student: {{ $p->student->name ?? 'N/A' }} • Status: {{ ucfirst($p->status) }}
                                    </div>
                                </div>
                                <a class="text-blue-600 hover:text-blue-800" href="{{ route('supervisor.projects') }}">Manage</a>
                            </div>
                        @empty
                            <div class="py-2 text-gray-500">No active projects.</div>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a class="text-blue-600 hover:text-blue-800" href="{{ route('supervisor.history') }}">
                            Completed: {{ $completedCount }} — View History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>