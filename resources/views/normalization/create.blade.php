<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Normalization') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                <div class="flex flex-col items-start gap-y-4">
                    <h2 class="text-2xl font-bold">Standard Word Dictionary</h2>
                    <ul class="list-disc pl-5">
                        @forelse($dictionaries as $dictionary)
                            <li class="flex justify-between items-center">
                                <span>{{ $dictionary->id }} - {{ $dictionary->name }}</span>
                                <form action="{{ route('normalization.destroy', $dictionary->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamus ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="text-red-500 font-bold">Tidak ada data kamus kata baku</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex flex-row justify-between items-center mb-6">
                    <span class="text-white font-bold bg-red-500 rounded-2xl w-fit p-5">
                        Pastikan Anda sudah mengunggah kamus kata baku untuk menormalisasi dataset!
                    </span>
                </div>
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col justify-start">
                        <h3 class="text-2xl font-bold mb-2">Word Dictionary Available:</h3>
                        <span class="text-5xl font-bold text-center text-black-700">{{ $dictionaryCount }}</span>
                    </div>
                    <a href="{{ route('normalization.upload') }}" class="py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Upload Dictionary
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('normalization.normalize') }}" method="POST" enctype="multipart/form-data" id="normalizationForm">
                    @csrf

                    <div class="mb-4">
                        <label for="dataset" class="block text-sm font-medium text-gray-700">Pilih Dataset</label>
                        <select id="dataset" name="dataset" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Choose Dataset</option>
                            @foreach($datasets as $dataset)
                                <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="dictionary" class="block text-sm font-medium text-gray-700">Pilih Kamus</label>
                        <select id="dictionary" name="dictionary" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            <option value="">Choose Dictionary</option>
                            @foreach($dictionaries as $dictionary)
                                <option value="{{ $dictionary->id }}">{{ $dictionary->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Normalization
                    </button>
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
        const normalizationForm = document.getElementById('normalizationForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        normalizationForm.addEventListener('submit', function() {
            // Tampilkan overlay loading
            loadingOverlay.classList.remove('hidden');
        });
    </script>
</x-app-layout>
