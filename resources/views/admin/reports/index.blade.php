<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: Reports & Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
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

                <!-- Document Template Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Manage Document Templates</h3>
                        <p class="text-sm text-gray-500 mt-1">Upload and manage templates for students (Requirement SDM-4).</p>
                        <div class="mt-4">
                            <label for="template_upload" class="block text-sm font-medium text-gray-700">Upload New Template</label>
                            <input type="file" id="template_upload" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-md font-medium text-gray-800">Existing Templates</h4>
                            <ul class="mt-2 space-y-2">
                                <li class="flex justify-between items-center p-2 border rounded-md">
                                    <span>Scope_Document_Template_v2.pdf</span>
                                    <div>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 mr-3">Download</a>
                                        <a href="#" class="text-sm text-red-600 hover:text-red-800">Delete</a>
                                    </div>
                                </li>
                                <li class="flex justify-between items-center p-2 border rounded-md">
                                    <span>Final_Report_Format.pdf</span>
                                    <div>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 mr-3">Download</a>
                                        <a href="#" class="text-sm text-red-600 hover:text-red-800">Delete</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>