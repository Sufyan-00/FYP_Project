<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Evaluation Committees</h2>
            <a href="{{ route('admin.committees.create') }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm">New Committee</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    @if($committees->isEmpty())
                        <p class="text-gray-500">No committees created yet.</p>
                    @else
                        <div class="divide-y">
                            @foreach ($committees as $c)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <div class="font-medium">{{ $c->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $c->members_count }} members</div>
                                    </div>
                                    <a class="text-indigo-600 hover:underline" href="{{ route('admin.committees.show', $c) }}">Manage</a>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">{{ $committees->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>