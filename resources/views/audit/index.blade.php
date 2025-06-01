<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-800 dark:text-blue-500 leading-tight">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('audit.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="project_id" :value="__('Project')" />
                                <select name="project_id" id="project_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All Projects</option>
                                    @foreach($projects as $id => $name)
                                        <option value="{{ $id }}" {{ request('project_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="action" :value="__('Action')" />
                                <select name="action" id="action" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">All Actions</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                            {{ ucfirst($action) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="from_date" :value="__('From Date')" />
                                <x-text-input type="date" name="from_date" id="from_date" 
                                    value="{{ request('from_date') }}" 
                                    class="mt-1 block w-full" />
                            </div>

                            <div>
                                <x-input-label for="to_date" :value="__('To Date')" />
                                <x-text-input type="date" name="to_date" id="to_date" 
                                    value="{{ request('to_date') }}" 
                                    class="mt-1 block w-full" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Filter') }}
                            </x-primary-button>
                            @if(request()->hasAny(['project_id', 'action', 'from_date', 'to_date']))
                                <a href="{{ route('audit.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50">
                                    {{ __('Clear Filters') }}
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Logs Table -->
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
                                        Project
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
                                            @php
                                                $project = \App\Models\Project::find($log->model_id);
                                            @endphp
                                            {{ $project ? $project->project_name : 'Deleted Project' }}
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
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No audit logs found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->withQueryString()->links() }}
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