<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Datasets') }}
            </h2>
            <a href="{{ route('datasets.create') }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                Upload New Dataset
            </a>
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">

                @forelse($datasets as $dataset)
                <div class="item-card flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $dataset->name }}</h3>
                            <p class="text-gray-500">{{ ucfirst($dataset->status) }}</p>
                        </div>
                    </div>
                    <div class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Uploaded On</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $dataset->created_at->format('M d, Y') }}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        <a href="{{ route('datasets.show', $dataset->id) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                            View
                        </a>
                        <form action="{{ route('datasets.destroy', $dataset) }}" method="POST" id="delete-form-{{ $dataset->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $dataset->id }}')" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p>
                    Belum ada dataset yang diunggah.
                </p>
                @endforelse

            </div>
        </div>
    </div>

    <script>
        function confirmDelete(datasetId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim form untuk menghapus dataset
                    document.getElementById(`delete-form-${datasetId}`).submit();

                    // Tampilkan pesan sukses setelah penghapusan
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your dataset has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                }
            });
        }
    </script>



</x-app-layout>
