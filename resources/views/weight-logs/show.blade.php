<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weight Log Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('weight-logs.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Weight Logs</a>
                    <h1 class="text-2xl font-bold text-gray-900">Weight Log</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('weight-logs.edit', $weightLog) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Log
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Weight Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Weight Information</h2>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Client</dt>
                                <dd class="text-sm text-gray-900">
                                    <a href="{{ route('clients.show', $weightLog->client) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $weightLog->client->full_name }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="text-sm text-gray-900">{{ $weightLog->date->format('F d, Y') }}</dd>
                            </div>
                            @if($weightLog->morning_weight)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Morning Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $weightLog->morning_weight }} kg</dd>
                            </div>
                            @endif
                            @if($weightLog->night_weight)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Night Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $weightLog->night_weight }} kg</dd>
                            </div>
                            @endif
                            @if($weightLog->average_weight)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Average Weight</dt>
                                <dd class="text-lg font-bold text-green-600">{{ $weightLog->average_weight }} kg</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Client Progress Overview -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Client Progress Overview</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-blue-50 rounded-lg">
                                    <div class="text-2xl font-bold text-blue-600">{{ $weightLog->client->starting_weight }} kg</div>
                                    <div class="text-sm text-gray-600">Starting Weight</div>
                                </div>
                                <div class="text-center p-4 bg-green-50 rounded-lg">
                                    <div class="text-2xl font-bold text-green-600">{{ $weightLog->client->goal_weight }} kg</div>
                                    <div class="text-sm text-gray-600">Goal Weight</div>
                                </div>
                                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                    <div class="text-2xl font-bold text-yellow-600">
                                        {{ $weightLog->average_weight ?? $weightLog->morning_weight ?? $weightLog->night_weight }} kg
                                    </div>
                                    <div class="text-sm text-gray-600">Current Weight</div>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('clients.progress', $weightLog->client) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    View Full Progress Chart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
