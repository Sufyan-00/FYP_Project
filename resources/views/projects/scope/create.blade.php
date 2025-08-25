<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Scope Document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Project: <span class="font-normal">{{ $project->title }}</span></h3>
                    <p class="mb-6 text-sm text-gray-600">Please upload your final scope document. The document must be in PDF format and no larger than 10MB.</p>
                    
                    {{-- The form needs a new route and enctype for file uploads --}}
                    {{-- We will create the 'projects.scope.store' route in the next step --}}
                        <form method="POST" action="{{ route('projects.scope.store', $project) }}" enctype="multipart/form-data">
                            @csrf

                        <!-- File Input -->
                        <div class="mb-4">
                            <label for="scope_document" class="block text-gray-700 text-sm font-bold mb-2">Scope Document (PDF only):</label>
                            <input type="file" id="document" name="document" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            @error('scope_document')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>