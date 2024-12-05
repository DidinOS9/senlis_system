<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dataset Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">{{ $dataset->name }}</h3>

                <div class="mb-6">
                    <p><strong>Status:</strong> {{ ucfirst($dataset->status) }}</p>
                    <p><strong>Uploaded On:</strong> {{ $dataset->created_at->format('M d, Y') }}</p>
                    <p><strong>Jumlah Data:</strong> {{ count($dataset->full_text) }} data</p>
                </div>

                <h4 class="text-xl font-bold mt-4">Dataset Overview</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">#</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Full Text</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Label</th>
                                <th class="border px-4 py-2 text-left text-sm font-medium text-gray-600">Normalized Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataset->full_text as $index => $text)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2 text-sm text-gray-700">{{ $text }}</td>
                                <td class="border px-4 py-2 text-sm text-gray-700">{{ $dataset->label[$index] ?? 'N/A' }}</td>
                                <td class="border px-4 py-2 text-sm text-gray-700">
                                    @if (isset($dataset->normalized_text[$index]))
                                        {{ $dataset->normalized_text[$index]}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <a href="{{ route('datasets.index') }}" class="py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Back to Datasets
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
