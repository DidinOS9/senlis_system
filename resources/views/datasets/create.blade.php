<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dataset') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
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

                <form action="{{ route('datasets.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Dataset</label>
                        <input type="text" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="name" required>
                    </div>

                    <div class="mb-4">
                        <label for="dataset" class="block text-sm font-medium text-gray-700">File Dataset (CSV/Excel)</label>
                        <input type="file" name="dataset" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="dataset" required>
                        <p id="fileError" class="text-red-500 mt-2 hidden">File harus berformat CSV atau Excel (xlsx).</p>
                    </div>

                    <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Add Dataset
                    </button>

                    <a href="{{ url()->previous() }}" class="mt-4 ml-4 py-2 px-4 bg-gray-500 text-white rounded-full inline-block text-center">
                        Back
                    </a>
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
        const uploadForm = document.getElementById('uploadForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        uploadForm.addEventListener('submit', function(event) {
            const fileInput = document.getElementById('dataset');
            const filePath = fileInput.value;
            const allowedExtensions = /(\.csv|\.xlsx)$/i;

            // Validasi file
            if (!allowedExtensions.exec(filePath)) {
                event.preventDefault(); // Mencegah pengiriman form
                document.getElementById('fileError').classList.remove('hidden'); // Tampilkan peringatan
                fileInput.value = ''; // Hapus file yang tidak valid
            } else {
                document.getElementById('fileError').classList.add('hidden'); // Sembunyikan peringatan jika file valid
                // Tampilkan overlay loading
                loadingOverlay.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
