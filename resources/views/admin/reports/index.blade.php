<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Administrative Reports</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Administrative Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Generate Reports</h3>
                        <p class="text-sm text-gray-500 mt-1">Export key system data for administrative review (Requirement NRS-3).</p>
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between items-center p-3 border rounded-md">
                                <span>All Approved Projects List</span>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Export as PDF</a>
                            </div>
                            <div class="flex justify-between items-center p-3 border rounded-md">
                                <span>Supervisor Workload Report</span>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Export as Excel</a>
                            </div>
                            <div class="flex justify-between items-center p-3 border rounded-md">
                                <span>Projects Pending Approval</span>
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Export as PDF</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Document Template Management (link-only; authoritative screen is admin/templates) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Manage Document Templates</h3>
                                <p class="text-sm text-gray-500 mt-1">Go to the templates management area (Requirement SDM-4).</p>
                            </div>
                            <a href="{{ route('admin.templates.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Open Templates
                            </a>
                        </div>
                        <p class="text-sm text-gray-500 mt-4">
                            This page no longer duplicates template upload/list UI. Use the Templates screen to upload, download, and delete templates.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>