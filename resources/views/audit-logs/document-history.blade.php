<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document History') }} - {{ $document->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('databank') }}" class="text-blue-600 hover:text-blue-900">
                            ← Back to Databank
                        </a>
                    </div>

                    <!-- Document Information -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document Details</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Document Title</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Owner</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $document->created_at->format('Y-m-d H:i:s') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- History Timeline -->
                    <div class="relative">
                        <div class="border-l-2 border-gray-200 ml-3">
                            @foreach($auditLogs as $log)
                                <div class="mb-8 ml-6">
                                    <!-- Timeline Dot -->
                                    <div class="absolute w-4 h-4 bg-blue-500 rounded-full -left-1 mt-2"></div>
                                    
                                    <!-- Event Card -->
                                    <div class="bg-white p-4 rounded-lg shadow">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">
                                                    {{ ucfirst($log->event) }}
                                                </h4>
                                                <p class="text-sm text-gray-500">
                                                    by {{ $log->user->name ?? 'System' }}
                                                </p>
                                            </div>
                                            <span class="text-sm text-gray-500">
                                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                                            </span>
                                        </div>

                                        @if($log->event === 'updated')
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Previous Values</h5>
                                                    <dl class="space-y-1">
                                                        @foreach($log->old_values as $field => $value)
                                                            <div>
                                                                <dt class="text-xs font-medium text-gray-500">
                                                                    {{ ucfirst($field) }}
                                                                </dt>
                                                                <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                                            </div>
                                                        @endforeach
                                                    </dl>
                                                </div>
                                                <div>
                                                    <h5 class="text-sm font-medium text-gray-700 mb-2">New Values</h5>
                                                    <dl class="space-y-1">
                                                        @foreach($log->new_values as $field => $value)
                                                            <div>
                                                                <dt class="text-xs font-medium text-gray-500">
                                                                    {{ ucfirst($field) }}
                                                                </dt>
                                                                <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                                            </div>
                                                        @endforeach
                                                    </dl>
                                                </div>
                                            </div>
                                        @elseif($log->event === 'created')
                                            <div class="mt-4">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Initial Values</h5>
                                                <dl class="space-y-1">
                                                    @foreach($log->new_values as $field => $value)
                                                        <div>
                                                            <dt class="text-xs font-medium text-gray-500">
                                                                {{ ucfirst($field) }}
                                                            </dt>
                                                            <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                                        </div>
                                                    @endforeach
                                                </dl>
                                            </div>
                                        @elseif($log->event === 'deleted')
                                            <div class="mt-4">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Deleted Values</h5>
                                                <dl class="space-y-1">
                                                    @foreach($log->old_values as $field => $value)
                                                        <div>
                                                            <dt class="text-xs font-medium text-gray-500">
                                                                {{ ucfirst($field) }}
                                                            </dt>
                                                            <dd class="text-sm text-gray-900">{{ $value }}</dd>
                                                        </div>
                                                    @endforeach
                                                </dl>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $auditLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 