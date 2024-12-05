<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('TF-IDF Weights - Detail') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">TF-IDF Results for Dataset: {{ $dataset->name }}</h3>

                <div class="my-6">
                    <a href="{{ route('tfidf.index') }}" class="py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Back to TF-IDF List
                    </a>
                </div>

                <div class="overflow-x-auto" style="max-height: 300px; overflow-y: auto;">
                    <table class="min-w-full border border-gray-300 mb-6">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">No</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Term</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">DF</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">d/DF</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">IDF</th>
                                @for ($i = 0; $i < count($tfidf_weights[0]) - 4; $i++)
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">TF Doc {{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tfidf_weights as $index => $tfidf_row)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="border px-4 py-2 text-sm text-gray-700">{{ $tfidf_row['term'] }}</td>
                                    <td class="border px-4 py-2 text-sm text-gray-700">{{ $tfidf_row['df'] }}</td>
                                    <td class="border px-4 py-2 text-sm text-gray-700">{{ $tfidf_row['d/df'] }}</td>
                                    <td class="border px-4 py-2 text-sm text-gray-700">{{ $tfidf_row['idf'] }}</td>
                                    @for ($i = 0; $i < count($tfidf_weights[0]) - 4; $i++)
                                        <td class="border px-4 py-2 text-sm text-gray-700">{{ $tfidf_row["tf_doc_{$i}"] }}</td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
