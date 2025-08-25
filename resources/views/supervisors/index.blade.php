<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Supervisors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Search and Filter Bar -->
                    <div class="mb-6">
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search by name or research interest (e.g., AI, Cybersecurity)...">
                    </div>

                    <!-- Supervisor List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Supervisor Card 1 -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <h3 class="text-lg font-bold text-gray-900">Dr. Alice Weber</h3>
                            <p class="text-sm text-gray-600">Research Interests: AI, Machine Learning, NLP</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Available Slots:</span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    3 / 8
                                </span>
                            </div>
                        </div>

                        <!-- Supervisor Card 2 -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <h3 class="text-lg font-bold text-gray-900">Dr. Bob Smith</h3>
                            <p class="text-sm text-gray-600">Research Interests: Cybersecurity, Network Security</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Available Slots:</span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    7 / 8
                                </span>
                            </div>
                        </div>

                        <!-- Supervisor Card 3 -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <h3 class="text-lg font-bold text-gray-900">Dr. Carol White</h3>
                            <p class="text-sm text-gray-600">Research Interests: Data Science, Big Data Analytics</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Available Slots:</span>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    8 / 8
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>