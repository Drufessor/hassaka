<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Project') }}
        </h2>
            <div class="flex gap-3">
                <a href="{{ route('project.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                @can('update', $project)
                    <a href="{{ route('project.edit', $project->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informasi Project</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->date->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Project</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->project_name }}</p>
                    </div>
                        <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tim Project</h3>
                                <div class="mt-4 space-y-4">
                        <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Owner</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->owner->name }}</p>
                        </div>
                        <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Oleh</label>
                                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $project->creator->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Deskripsi</h3>
                        <div class="mt-4 prose dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-400">{{ $project->description }}</p>
                        </div>
                    </div>

                    @can('delete', $project)
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <form action="{{ route('project.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus Project
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
