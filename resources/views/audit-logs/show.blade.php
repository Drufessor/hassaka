<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Log Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('audit-logs.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Back to Audit Logs
                        </a>
                    </div>

                    <!-- Basic Information -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Event Information</h3>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date/Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $auditLog->created_at->format('Y-m-d H:i:s') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">User</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $auditLog->user->name ?? 'System' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ ucfirst($auditLog->event) }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Model</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ class_basename($auditLog->auditable_type) }} #{{ $auditLog->auditable_id }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">URL</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $auditLog->url }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $auditLog->ip_address }}
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Changes -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Changes</h3>
                        @if($auditLog->event === 'updated')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Old Values -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Old Values</h4>
                                    <dl class="space-y-2">
                                        @foreach($auditLog->old_values as $field => $value)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">{{ ucfirst($field) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                                <!-- New Values -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">New Values</h4>
                                    <dl class="space-y-2">
                                        @foreach($auditLog->new_values as $field => $value)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">{{ ucfirst($field) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            </div>
                        @elseif($auditLog->event === 'created')
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-2">Created Values</h4>
                                <dl class="space-y-2">
                                    @foreach($auditLog->new_values as $field => $value)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">{{ ucfirst($field) }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @elseif($auditLog->event === 'deleted')
                            <div>
                                <h4 class="text-md font-medium text-gray-700 mb-2">Deleted Values</h4>
                                <dl class="space-y-2">
                                    @foreach($auditLog->old_values as $field => $value)
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">{{ ucfirst($field) }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 