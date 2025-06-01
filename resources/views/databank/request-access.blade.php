<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-blue-500 leading-tight">
            {{ __('Request Access') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Request Access untuk Dokumen: {{ $document->title }}</h3>
                    
                    <div class="mb-4">
                        <p>Pemilik: {{ $document->user->name }}</p>
                        <p>Tanggal Upload: {{ $document->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <form action="{{ route('databank.request-access.submit', $document) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Tipe Akses yang Diminta:</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="can_edit" value="1" class="rounded border-gray-300">
                                    <span class="ml-2">Akses Edit</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="can_delete" value="1" class="rounded border-gray-300">
                                    <span class="ml-2">Akses Hapus</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Pesan untuk Pemilik:</label>
                            <textarea name="message" rows="3" class="w-full rounded-md shadow-sm border-gray-300" required></textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('databank') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Kirim Permintaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 