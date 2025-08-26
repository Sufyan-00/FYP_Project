<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Defence Sessions</h2>
            <a href="{{ route('admin.defence-sessions.create') }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm">Schedule Session</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @if ($sessions->isEmpty())
                        <p class="text-gray-500">No sessions yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-600">
                                        <th class="py-2 pr-4">Project</th>
                                        <th class="py-2 pr-4">Committee</th>
                                        <th class="py-2 pr-4">Scheduled</th>
                                        <th class="py-2 pr-4">Venue</th>
                                        <th class="py-2 pr-4">Status</th>
                                        <th class="py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($sessions as $s)
                                        <tr>
                                            <td class="py-2 pr-4">{{ $s->project->title ?? '—' }}</td>
                                            <td class="py-2 pr-4">{{ $s->committee->name }}</td>
                                            <td class="py-2 pr-4">{{ $s->scheduled_at->format('Y-m-d H:i') }}</td>
                                            <td class="py-2 pr-4">{{ $s->venue ?: '—' }}</td>
                                            <td class="py-2 pr-4">
                                                <span class="px-2 py-0.5 rounded-full text-xs bg-gray-100">{{ ucfirst($s->status) }}</span>
                                            </td>
                                            <td class="py-2">
                                                <a class="text-indigo-600 hover:underline" href="{{ route('admin.defence-sessions.show', $s) }}">Open</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $sessions->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>