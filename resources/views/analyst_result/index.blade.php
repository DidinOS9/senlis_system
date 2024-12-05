<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analysis Results') }}
            </h2>
            <a href="{{ route('analysis_result.create') }}" class="font-bold py-3 px-5 bg-indigo-700 hover:bg-indigo-800 text-white rounded-full transition duration-150 ease-in-out">
                Add New Analysis Result
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-6 text-indigo-700">Results of Sentiment Analysis</h3>

                @forelse ($analysis_results as $analysis)
                    <div class="mb-8 p-6 border border-gray-200 bg-gray-50 rounded-lg">
                        <h4 class="text-xl font-bold mb-4 text-gray-900">{{ $analysis->dataset->name }}</h4>

                        <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <p class="text-gray-700">
                                <strong>Naive Bayes Accuracy:</strong> {{ json_decode($analysis->method_nb)->accuracy ?? 'N/A' }}%
                            </p>
                            <p class="text-gray-700">
                                <strong>SVM Accuracy:</strong> {{ json_decode($analysis->method_svm)->accuracy ?? 'N/A' }}%
                            </p>
                        </div>

                        <!-- Gambar Confusion Matrix -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h5 class="text-lg font-semibold">Naive Bayes Confusion Matrix</h5>
                                @if(isset($analysis->dataset->confussion_matrix_path) && json_decode($analysis->dataset->confussion_matrix_path)->nb)
                                    {{-- <p>{{ Storage::url(json_decode($analysis->dataset->confussion_matrix_path)->nb) }}</p> --}}
                                    <img src="{{ Storage::url(json_decode($analysis->dataset->confussion_matrix_path)->nb) }}" alt="Naive Bayes Confusion Matrix" class="mt-2 w-full h-auto rounded shadow-md">
                                @else
                                    <p class="text-sm text-gray-500">No Naive Bayes Confusion Matrix Available</p>
                                @endif
                            </div>

                            <div>
                                <h5 class="text-lg font-semibold">SVM Confusion Matrix</h5>
                                @if(isset($analysis->dataset->confussion_matrix_path) && json_decode($analysis->dataset->confussion_matrix_path)->svm)
                                    <img src="{{ Storage::url(json_decode($analysis->dataset->confussion_matrix_path)->svm) }}" alt="SVM Confusion Matrix" class="mt-2 w-full h-auto rounded shadow-md">
                                @else
                                    <p class="text-sm text-gray-500">No SVM Confusion Matrix Available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Gambar Frekuensi Kata dan Word Cloud -->
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h5 class="text-lg font-semibold">Word Frequency Chart</h5>
                                @if($analysis->dataset->freq_chart_path)
                                    {{-- <p>{{ Storage::url($analysis->dataset->freq_chart_path) }}</p> --}}
                                    <img src="{{ Storage::url($analysis->dataset->freq_chart_path) }}" alt="Word Frequency Chart" class="mt-2 w-full h-auto rounded shadow-md">
                                @else
                                    <p class="text-sm text-gray-500">No Word Frequency Chart Available</p>
                                @endif
                            </div>

                            <div>
                                <h5 class="text-lg font-semibold">Word Cloud</h5>
                                @if($analysis->dataset->word_cloud_path)
                                    {{-- <p>{{ Storage::url($analysis->dataset->word_cloud_path) }}</p> --}}
                                    <img src="{{ Storage::url($analysis->dataset->word_cloud_path) }}" alt="Word Cloud" class="mt-2 w-full h-auto rounded shadow-md">
                                @else
                                    <p class="text-sm text-gray-500">No Word Cloud Available</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-300">
                @empty
                    <p class="text-center text-gray-700">No analysis results available.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
