<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Preprocessing') }}
            </h2>
            <a href="{{ route('preprocessing.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Preprocessing
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">Preprocessing Data</h3>

                @foreach ($preprocessings as $preprocessing)
                    <h4 class="text-xl font-bold mt-4">{{ $preprocessing->dataset->name }}</h4>

                    <div class="overflow-x-auto" style="max-height: 300px; overflow-y: auto;">
                        <table class="min-w-full border border-gray-300 mb-6">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Cleaned Sentence</th>
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Tokenized Sentence</th>
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Stopword Sentence</th>
                                    <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Stemmed Sentence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Decode setiap kolom preprocessing
                                    $cleaned = json_decode($preprocessing->cleaned_sentence, true);
                                    $tokenized = json_decode($preprocessing->tokenized_sentence, true);
                                    $stopword = json_decode($preprocessing->stopword_sentence, true);
                                    $stemmed = json_decode($preprocessing->stemmed_sentence, true);

                                    // Tentukan jumlah elemen terbesar
                                    $max_count = max(count($cleaned), count($tokenized), count($stopword), count($stemmed));
                                @endphp


                                @for ($i = 0; $i < $max_count; $i++)
                                    <tr class="hover:bg-gray-100">
                                        <!-- Nomor baris -->
                                        <td class="border px-4 py-2 text-sm text-gray-700">{{ $i + 1 }}</td>

                                        <!-- Cleaned Sentence -->
                                        <td class="border px-4 py-2 text-sm text-gray-700">
                                            {{ isset($cleaned[$i]) ? implode(', ', (array)$cleaned[$i]) : 'N/A' }}
                                        </td>

                                        <!-- Tokenized Sentence -->
                                        <td class="border px-4 py-2 text-sm text-gray-700">
                                            {{ isset($tokenized[$i]) ? implode(', ', (array)$tokenized[$i]) : 'N/A' }}
                                        </td>

                                        <!-- Stopword Sentence -->
                                        <td class="border px-4 py-2 text-sm text-gray-700">
                                            {{ isset($stopword[$i]) ? implode(', ', (array)$stopword[$i]) : 'N/A' }}
                                        </td>

                                        <!-- Stemmed Sentence -->
                                        <td class="border px-4 py-2 text-sm text-gray-700">
                                            {{ isset($stemmed[$i]) ? implode(', ', (array)$stemmed[$i]) : 'N/A' }}
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <div class="mt-6">
                    <a href="{{ route('preprocessing.create') }}" class="py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Add New Preprocessing
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
