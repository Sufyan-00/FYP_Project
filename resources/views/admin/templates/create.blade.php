<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Template
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.templates.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Template Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md" required>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Template File (PDF/DOC/DOCX, max 10MB)</label>
                            <input type="file" name="document" accept=".pdf,.doc,.docx"
                                   class="mt-1 block w-full" required>
                            @error('document')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.templates.index') }}" class="px-4 py-2 mr-3 rounded border">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>