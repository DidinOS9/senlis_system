<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('TF-IDF Weights') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Pilih Dataset untuk TF-IDF Weights</h3>

                <!-- Tampilkan Pesan Sukses -->
                @if(session('success'))
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Tampilkan Pesan Error -->
                @if($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card untuk Split Data -->
                <div class="mb-8 p-4 bg-gray-100 rounded-lg shadow-md">
                    <h4 class="text-lg font-bold mb-4">Split Data</h4>
                    <form action="{{ route('tfidf.split') }}" method="POST" id="splitForm">
                        @csrf
                        <div class="mb-4">
                            <label for="dataset" class="block text-sm font-medium text-gray-700">Pilih Dataset</label>
                            <select id="split_dataset" name="dataset" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Select a dataset</option>
                                @foreach($datasets as $dataset)
                                    <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="test_size" class="block text-sm font-medium text-gray-700">Rasio Data Uji (%)</label>
                            <input type="number" id="test_size" name="test_size" value="10" min="5" max="50" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" readonly>
                        </div>

                        <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                            Split Data
                        </button>
                    </form>
                </div>

                <!-- Card untuk TF-IDF -->
                <div class="p-4 bg-gray-100 rounded-lg shadow-md">
                    <h4 class="text-lg font-bold mb-4">Perhitungan TF-IDF</h4>
                    <form action="{{ route('tfidf.store') }}" method="POST" id="tfidfForm">
                        @csrf
                        <div class="mb-4">
                            <label for="dataset" class="block text-sm font-medium text-gray-700">Pilih Dataset</label>
                            <select id="tfidf_dataset" name="dataset" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih dataset yang telah di-split</option>
                                @foreach($datasets as $dataset)
                                    <option value="{{ $dataset->id }}" {{ $dataset->status === 'split' ? '' : 'disabled' }}>
                                        {{ $dataset->name }} ({{ ucfirst($dataset->status) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                            Mulai Perhitungan TF-IDF
                        </button>
                    </form>
                </div>
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
        // Split Form Loading
        const splitForm = document.getElementById('splitForm');
        const splitDataset = document.getElementById('split_dataset');
        splitForm.addEventListener('submit', function (event) {
            if (!splitDataset.value) {
                event.preventDefault();
                alert('Pilih dataset untuk Split Data');
            } else {
                document.getElementById('loadingOverlay').classList.remove('hidden');
            }
        });

        // TF-IDF Form Loading
        const tfidfForm = document.getElementById('tfidfForm');
        const tfidfDataset = document.getElementById('tfidf_dataset');
        tfidfForm.addEventListener('submit', function (event) {
            if (!tfidfDataset.value) {
                event.preventDefault();
                alert('Pilih dataset untuk TF-IDF');
            } else {
                document.getElementById('loadingOverlay').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
