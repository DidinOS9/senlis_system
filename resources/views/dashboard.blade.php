<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Message -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-semibold">Welcome back!</h3>
                    <p class="mt-2 text-gray-600">{{ __("Here's an overview of your activity and latest updates.") }}</p>
                </div>
            </div>

             <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Datasets Card -->
                <a href="{{ route('datasets.index') }}" class="bg-white p-6 rounded-lg shadow-sm flex items-center hover:bg-gray-100 transition">
                    <div class="flex-shrink-0 bg-indigo-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xl font-semibold text-gray-900">Datasets</p>
                        <p class="text-gray-600">Manage and analyze datasets</p>
                    </div>
                </a>

                <!-- Analyses Card -->
                <a href="{{ route('analysis_result.index') }}" class="bg-white p-6 rounded-lg shadow-sm flex items-center hover:bg-gray-100 transition">
                    <div class="flex-shrink-0 bg-green-500 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xl font-semibold text-gray-900">Analyses</p>
                        <p class="text-gray-600">View recent analysis results</p>
                    </div>
                </a>

                <!-- Settings Card -->
                <a href="{{ route('profile.edit') }}" class="bg-white p-6 rounded-lg shadow-sm flex items-center hover:bg-gray-100 transition">
                    <div class="flex-shrink-0 bg-yellow-500 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8-8h1M4 12H3m15.36-4.64l.7.7m-12.02 0l.7.7m12.02 8.48l-.7.7M6.64 17.36l-.7.7M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-xl font-semibold text-gray-900">Settings</p>
                        <p class="text-gray-600">Adjust your account preferences</p>
                    </div>
                </a>
            </div>

            <!-- Recent Activity Section -->
            {{-- <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Recent Activity</h3>
                    <ul class="space-y-4">
                        <!-- Activity Item -->
                        <li class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-blue-500 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582a2 2 0 001.664.892l8 4.8a2 2 0 002.268-3.268l-8-4.8a2 2 0 00-.738-.332L4 4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700"><strong>New Dataset Uploaded</strong> - "Customer Reviews"</p>
                                <p class="text-gray-500 text-sm">2 days ago</p>
                            </div>
                        </li>
                        
                        <!-- Additional Activity Items -->
                        <li class="flex items-center space-x-4">
                            <div class="flex-shrink-0 bg-red-500 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-700"><strong>Analysis Completed</strong> - Naive Bayes sentiment analysis</p>
                                <p class="text-gray-500 text-sm">1 day ago</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div> --}}

        </div>
    </div>
</x-app-layout>
