<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Normalization') }}
            </h2>
            <a href="{{ route('normalization.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Normalization
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                
                <!-- Button untuk Lexicon Labelling -->
                <div class="flex flex-col items-start gap-y-4">
                    <!-- Pesan bahwa fitur belum tersedia -->
                    <p class="text-gray-600 italic">
                        Lakukan proses Normalisasi dengan menekan tombol "Normalization" di pojok kanan atas!
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
