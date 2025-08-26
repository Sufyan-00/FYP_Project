<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Assigned Sessions</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @if ($assignments->isEmpty())
                        <p class="text-gray-500">No assignments yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-600">
                                        <th class="py-2 pr-4">Project</th>
                                        <th class="py-2 pr-4">Committee</th>
                                        <th class="py-2 pr-4">When</th>
                                        <th class="py-2 pr-4">Status</th>
                                        <th class="py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @foreach ($assignments as $a)
                                        <tr>
                                            <td class="py-2 pr-4">{{ $a->session->project->title ?? '—' }}</td>
                                            <td class="py-2 pr-4">{{ $a->session->committee->name }}</td>
                                            <td class="py-2 pr-4">{{ optional($a->session->scheduled_at)->format('Y-m-d H:i') }}</td>
                                            <td class="py-2 pr-4">
                                                @if ($a->submitted_at)
                                                    <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">Submitted</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>
                                                @endif
                                            </td>
                                            <td class="py-2">
                                                <a class="text-indigo-600 hover:underline" href="{{ route('member.sessions.evaluate', $a->id) }}">
                                                    {{ $a->submitted_at ? 'View/Edit' : 'Evaluate' }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">{{ $assignments->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>