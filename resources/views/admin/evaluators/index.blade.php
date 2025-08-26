<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Evaluator Directory</h2>
            <a href="{{ route('admin.evaluators.create') }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm">Add Evaluator</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="GET" class="flex flex-wrap gap-3">
                    <select name="status" class="border-gray-300 rounded">
                        <option value="">All Statuses</option>
                        <option value="available" @selected(request('status')==='available')>Available</option>
                        <option value="assigned" @selected(request('status')==='assigned')>Assigned</option>
                    </select>
                    <button class="px-3 py-1.5 bg-gray-800 text-white rounded text-sm">Filter</button>
                </form>

                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Email</th>
                                <th class="py-2 pr-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($evaluators as $e)
                                <tr>
                                    <td class="py-2 pr-4">{{ $e->user->name }}</td>
                                    <td class="py-2 pr-4">{{ $e->user->email }}</td>
                                    <td class="py-2 pr-4">
                                        <span class="px-2 py-0.5 rounded-full text-xs {{ $e->status==='available' ? 'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700' }}">
                                            {{ ucfirst($e->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $evaluators->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>