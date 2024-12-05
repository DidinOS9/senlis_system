<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dictionary') }}
        </h2>
    </x-slot>
    
    <div class="py-2">
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

                <form action="{{ route('normalization.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Dictionary Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="dictionary_file" class="block text-sm font-medium text-gray-700">Standard Word Dictionary</label>
                        <input type="file" name="dictionary_file" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="dictionary_file" required>
                        <p id="fileError" class="text-red-500 mt-2 hidden">File harus berformat CSV atau Excel (xlsx).</p>
                    </div>

                    <button type="submit" class="mt-4 font-bold py-2 px-4 bg-indigo-700 text-white rounded-full">
                        Add Dictionary
                    </button>

                    <a href="{{ url()->previous() }}" class="mt-4 ml-4 py-2 px-4 bg-gray-500 text-white rounded-full inline-block text-center">
                        Back
                    </a>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            const fileInput = document.getElementById('dataset');
            const filePath = fileInput.value;
            const allowedExtensions = /(\.csv|\.xlsx|\.xls)$/i;

            if (!allowedExtensions.exec(filePath)) {
                event.preventDefault(); // Mencegah pengiriman form
                document.getElementById('fileError').classList.remove('hidden'); // Tampilkan peringatan
                fileInput.value = ''; // Hapus file yang tidak valid
            } else {
                document.getElementById('fileError').classList.add('hidden'); // Sembunyikan peringatan jika file valid
            }
        });
    </script>
</x-app-layout>
