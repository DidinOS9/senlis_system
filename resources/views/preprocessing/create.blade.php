<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preprocessing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Pilih Dataset untuk Preprocessing</h3>
                
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

                <!-- Form untuk Preprocessing -->
                <form action="{{ route('preprocessing.store') }}" method="POST" id="preprocessingForm">
                    @csrf
                    <div class="mb-4">
                        <label for="dataset" class="block text-sm font-medium text-gray-700">Pilih Dataset</label>
                        <select id="dataset" name="dataset" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            @foreach($datasets as $dataset)
                                <option value="{{ $dataset->id }}">{{ $dataset->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button untuk submit -->
                    <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Mulai Preprocessing
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

    <!-- Script untuk Menampilkan Overlay -->
    <script>
        document.getElementById('preprocessingForm').addEventListener('submit', function () {
            document.querySelector('button[type="submit"]').disabled = true;
            document.getElementById('loadingOverlay').classList.remove('hidden');
        });
    </script>
</x-app-layout>
