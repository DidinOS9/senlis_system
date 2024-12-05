<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sentiment Analysis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">Analyze Sentiment by Words, Phrases, or Sentences</h3>

                <!-- Form for text input and analysis method selection -->
                <form action="{{ route('analyze_text') }}" method="POST" class="space-y-6" id="analyzeForm">
                    @csrf

                    <!-- Dataset Selection -->
                    <div>
                        <label for="dataset_id" class="block text-sm font-medium text-gray-700">Select Dataset</label>
                        <select id="dataset_id" name="dataset_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                            <option value="" disabled>Select a dataset</option>
                            @foreach($datasets as $dataset)
                                <option value="{{ $dataset->id }}" 
                                    {{ session('dataset_id') == $dataset->id ? 'selected' : '' }}>{{ $dataset->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Text Input -->
                    <div>
                        <label for="text_input" class="block text-sm font-medium text-gray-700">Enter Text for Analysis</label>
                        <textarea id="text_input" name="text_input" rows="4" 
                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" 
                                  placeholder="Enter words, phrases, or sentences here..." required>{{ session('text_input') }}</textarea>
                    </div>

                    <!-- Analysis Method Selection -->
                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700">Select Analysis Method</label>
                        <select id="method" name="method" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                            <option value="naive_bayes" {{ session('method') == 'naive_bayes' ? 'selected' : '' }}>Naive Bayes</option>
                            <option value="svm" {{ session('method') == 'svm' ? 'selected' : '' }}>SVM</option>
                        </select>
                    </div>

                    <!-- Submit Button with Loading Spinner -->
                    <button type="submit" class="py-2 px-4 bg-indigo-700 text-white rounded-full font-bold flex items-center justify-center" id="analyzeButton">
                        <span>Analyze Sentiment</span>
                        <svg id="loadingSpinner" class="animate-spin ml-2 hidden h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                </form>

                <!-- Display Analysis Result -->
                @if (session('analysis_result'))
                    @php
                        $sentiment = session('analysis_result');
                        // Memeriksa dan mengubah warna berdasarkan nilai sentimen
                        $color = $sentiment === 'positif' ? 'text-green-600' : ($sentiment === 'negatif' ? 'text-red-600' : 'text-gray-600');
                    @endphp
                    <div class="mt-8">
                        <h4 class="text-lg font-bold">Analysis Result</h4>
                        <p class="mt-2 {{ $color }} text-lg"><strong>Sentiment:</strong> {{ ucfirst($sentiment) }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for Loading Spinner -->
    <script>
        document.getElementById('analyzeForm').addEventListener('submit', function() {
            document.getElementById('loadingSpinner').classList.remove('hidden');
            document.getElementById('analyzeButton').disabled = true;
        });
    </script>
</x-app-layout>
