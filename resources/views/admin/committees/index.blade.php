<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: Evaluation Committees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Create Committee Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Create New Committee</h3>
                            <form class="mt-4 space-y-4">
                                <div>
                                    <label for="committee_name" class="block text-sm font-medium text-gray-700">Committee Name</label>
                                    <input type="text" name="committee_name" id="committee_name" class="mt-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g., AI/ML Committee">
                                </div>
                                <div>
                                    <label for="committee_members" class="block text-sm font-medium text-gray-700">Assign Members</label>
                                    <select multiple name="committee_members[]" id="committee_members" class="mt-1 block w-full h-32 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                                        <option>Dr. Alice Weber</option>
                                        <option>Dr. Bob Smith</option>
                                        <option>Dr. Carol White</option>
                                        <option>Dr. David Green</option>
                                        <option>Dr. Eve Black</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple members.</p>
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Create Committee
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Committees List -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Existing Committees</h3>
                            <div class="mt-4 space-y-4">
                                <!-- Committee 1 -->
                                <div class="p-4 border rounded-md">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-md font-semibold text-gray-800">AI/ML Committee</h4>
                                        <button class="text-sm text-red-500 hover:text-red-700">Delete</button>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">Members: Dr. Alice Weber, Dr. Carol White</p>
                                </div>
                                <!-- Committee 2 -->
                                <div class="p-4 border rounded-md">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-md font-semibold text-gray-800">Cybersecurity Committee</h4>
                                        <button class="text-sm text-red-500 hover:text-red-700">Delete</button>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">Members: Dr. Bob Smith, Dr. David Green, Dr. Eve Black</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>