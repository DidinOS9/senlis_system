<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('TF-IDF Weights') }}
            </h2>
            <a href="{{ route('tfidf.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Add New TF-IDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">TF-IDF Results</h3>

                @forelse ($tfidf_weights as $tfidf_weight)
                    <div class="my-3 item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $tfidf_weight->dataset->name }}</h3>
                                <p class="text-gray-500">{{ ucfirst($tfidf_weight->dataset->status) }}</p>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Uploaded On</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $tfidf_weight->dataset->created_at->format('M d, Y') }}</h3>
                        </div>
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{ route('tfidf.show', $tfidf_weight->id) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <p>
                        Belum ada TF-IDF yang dihitung.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
