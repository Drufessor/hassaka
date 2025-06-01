<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Membuka Dokumen di Google Docs: ') . $document->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-grey dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium">Mengarahkan ke Google Docs...</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dokumen akan dibuka di Google Docs untuk pengeditan</p>
                        </div>
                        <a href="{{ route('databank') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Kembali ke Daftar</a>
                    </div>

                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mb-4"></div>
                        <p class="text-gray-600 dark:text-gray-400">Mengarahkan ke Google Docs...</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Jika tidak otomatis terarahkan, silakan klik link di bawah ini:</p>
                        <a href="{{ $googleDocsUrl }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" target="_blank">
                            Buka di Google Docs
                        </a>
                    </div>

                    <div class="mt-8 text-sm text-gray-500 dark:text-gray-400">
                        <p>Catatan:</p>
                        <ul class="list-disc list-inside mt-2">
                            <li>Dokumen akan dibuka di Google Docs</li>
                            <li>Anda dapat mengedit dokumen langsung di Google Docs</li>
                            <li>Perubahan akan otomatis tersimpan di Google Drive Anda</li>
                            <li>Jika tidak otomatis terarahkan, gunakan tombol "Buka di Google Docs" di atas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Automatically redirect to Google Docs after a short delay
        setTimeout(function() {
            window.location.href = "{{ $googleDocsUrl }}";
        }, 2000);
    </script>
</x-app-layout>
