<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Document Templates
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Existing Templates</h3>
                        <a href="{{ route('admin.templates.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Upload New
                        </a>
                    </div>

                    <div class="border rounded">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($templates as $template)
                                <tr>
                                    <td class="px-4 py-2">{{ $template->name }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('templates.download', $template) }}"
                                           class="text-blue-600 hover:text-blue-800 mr-4">Download</a>
                                        <form action="{{ route('admin.templates.destroy', $template) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Delete this template?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="px-4 py-4 text-gray-500" colspan="2">No templates uploaded yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>