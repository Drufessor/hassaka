<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-800 dark:text-blue-500 leading-tight">
            {{ __('Databank') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-grey dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-blue-900 dark:text-gray-100">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-medium">Dokumen</h3>
                        <div class="flex space-x-4">
                            <a href="{{ route('databank.upload') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Upload Dokumen
                            </a>
                            <a href="{{ route('databank.access-requests') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Permintaan Akses
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pemilik</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Upload</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-grey dark:bg-gray-800 divide-y divide-gray-200">
                                @forelse($documents as $document)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $document->title }}
                                            @if($document->user_id === auth()->id())
                                                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Pemilik</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $document->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $document->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-4">
                                                <a href="{{ route('databank.getFile', $document->filename) }}" 
                                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                    View
                                                </a>

                                                @if($document->canEdit(auth()->id()))
                                                    <a href="{{ route('databank.edit', $document) }}" 
                                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                        Edit
                                                    </a>
                                                @endif

                                                @if($document->hasAccess(auth()->id()))
                                                    <a href="{{ route('databank.history', $document) }}" 
                                                       class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                                        History
                                                    </a>
                                                @endif

                                                @if($document->canDelete(auth()->id()))
                                                    <form action="{{ route('databank.destroy', $document) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif

                                                @if(!$document->hasAccess(auth()->id()) && $document->user_id !== auth()->id())
                                                    <form action="{{ route('databank.request-access', $document) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                            Request Access
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada dokumen
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
