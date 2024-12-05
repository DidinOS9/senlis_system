<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Analysis Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">Perform Sentiment Analysis</h3>
                <p class="text-gray-600 mb-6">
                    Select a dataset to analyze its sentiment using Naive Bayes and SVM methods. Make sure the dataset has gone through preprocessing and TF-IDF stages.
                </p>

                <form action="{{ route('analysis_result.store') }}" method="POST" id="analysisForm">
                    @csrf

                    <!-- Dataset Selection -->
                    <div class="mb-6">
                        <label for="dataset" class="block text-sm font-medium text-gray-700">Choose Dataset</label>
                        <select id="dataset" name="dataset_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="" disabled selected>Select a dataset</option>
                            @foreach($datasets as $dataset)
                                <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                            @endforeach
                        </select>
                        @error('dataset_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Run Analysis Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="font-bold py-2 px-6 bg-indigo-700 text-white rounded-full hover:bg-indigo-800 transition duration-200">
                            Run Analysis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Overlay Loading -->
    <div id="loadingOverlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 hidden z-50 flex flex-col items-center justify-center">
        <svg class="animate-spin h-16 w-16 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C6.48 0 2 4.48 2 10h2zm2 5.291A7.961 7.961 0 014 12H2c0 2.386.928 4.548 2.43 6.071l1.57-1.78z"></path>
        </svg>
        <p class="mt-4 text-white text-2xl font-bold">Harap Tunggu...</p>
    </div>

    <script>
        // Analysis Form Loading
        const analysisForm = document.getElementById('analysisForm');
        const datasetSelect = document.getElementById('dataset');
        analysisForm.addEventListener('submit', function (event) {
            if (!datasetSelect.value) {
                event.preventDefault();
                alert('Pilih dataset untuk analisis');
            } else {
                document.getElementById('loadingOverlay').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
