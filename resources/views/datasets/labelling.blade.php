<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Labelling Dataset') }}
            </h2>
            <!-- Tombol Lexicon Labelling -->
            <button class="py-4 px-6 bg-gray-500 text-white rounded-full cursor-not-allowed">
                Lexicon Labelling
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                
                <!-- Button untuk Lexicon Labelling -->
                <div class="flex flex-col items-start gap-y-4">
                    <!-- Pesan bahwa fitur belum tersedia -->
                    <p class="text-gray-600 italic">
                        Labelling dengan Metode Lexicon Based belum tersedia.
                    </p>
                </div>

                <div class="mt-6">
                    <a href="{{ route('datasets.index') }}" class="py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Kembali ke Datasets
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
