<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project History:') }} {{ $project->project_name }}
            </h2>
            <a href="{{ route('project.show', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Back to Project') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $log->action === 'updated' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $log->action === 'viewed' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($log->action !== 'viewed')
                                                <button type="button" 
                                                    onclick="showDetails('{{ json_encode($log->old_values) }}', '{{ json_encode($log->new_values) }}')"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    View Changes
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No audit logs found for this project.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for showing changes -->
    <div id="detailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Changes</h3>
                <div class="mt-2">
                    <div id="oldValues" class="mb-4">
                        <h4 class="font-semibold text-sm text-gray-600">Old Values:</h4>
                        <pre class="mt-1 text-sm text-gray-500 whitespace-pre-wrap"></pre>
                    </div>
                    <div id="newValues">
                        <h4 class="font-semibold text-sm text-gray-600">New Values:</h4>
                        <pre class="mt-1 text-sm text-gray-500 whitespace-pre-wrap"></pre>
                    </div>
                </div>
                <div class="mt-4">
                    <button onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showDetails(oldValues, newValues) {
            const modal = document.getElementById('detailsModal');
            const oldValuesElement = document.querySelector('#oldValues pre');
            const newValuesElement = document.querySelector('#newValues pre');

            oldValuesElement.textContent = JSON.stringify(JSON.parse(oldValues), null, 2);
            newValuesElement.textContent = JSON.stringify(JSON.parse(newValues), null, 2);
            
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout> 