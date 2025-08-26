<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Schedule Defence Session</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.defence-sessions.store') }}" class="grid gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Committee</label>
                        <select name="committee_id" class="mt-1 w-full border-gray-300 rounded" required>
                            @foreach ($committees as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project</label>
                        <select name="project_id" class="mt-1 w-full border-gray-300 rounded" required>
                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Scheduled At</label>
                        <input type="datetime-local" name="scheduled_at" class="mt-1 w-full border-gray-300 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Venue</label>
                        <input type="text" name="venue" class="mt-1 w-full border-gray-300 rounded" placeholder="e.g., Seminar Hall A">
                    </div>
                    <div class="mt-2">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Schedule</button>
                        <a class="ml-3 text-gray-600" href="{{ route('admin.defence-sessions.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>