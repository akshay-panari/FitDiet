<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('clients.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Clients</a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $client->full_name }}</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('clients.progress', $client) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        View Progress
                    </a>
                    <a href="{{ route('clients.edit', $client) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Client
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Client Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Client Information</h2>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="text-sm text-gray-900">{{ $client->phone }}</dd>
                            </div>
                            @if($client->email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="text-sm text-gray-900">{{ $client->email }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Age</dt>
                                <dd class="text-sm text-gray-900">{{ $client->age }} years</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst($client->gender) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Height</dt>
                                <dd class="text-sm text-gray-900">{{ $client->height }} cm</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Starting Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $client->starting_weight }} kg</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Goal Weight</dt>
                                <dd class="text-sm text-gray-900">{{ $client->goal_weight }} kg</dd>
                            </div>
                            @if($client->medical_conditions)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Medical Conditions</dt>
                                <dd class="text-sm text-gray-900">{{ $client->medical_conditions }}</dd>
                            </div>
                            @endif
                            @if($client->notes)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="text-sm text-gray-900">{{ $client->notes }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Diet Plans and Weight Logs -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Diet Plans -->
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Diet Plans</h2>
                        </div>
                        <div class="p-6">
                            @forelse ($client->dietPlans as $plan)
                                <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-medium font-medium text-gray-900">{{ $plan->title }}</h3>
                                            <p class="text-sm text-gray-500">{{ $plan->start_date->format('M d, Y') }} - {{ $plan->end_date->format('M d, Y') }}</p>
                                            @if($plan->instructions)
                                                <p class="text-sm text-gray-600 mt-1">{{ $plan->instructions }}</p>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $plan->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $plan->status }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No diet plans yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Weight Logs -->
                    <div class="bg-white shadow sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h2 class="text-lg font-medium text-gray-900">Recent Weight Logs</h2>
                            <a href="{{ route('weight-logs.create') }}?client_id={{ $client->id }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                Add Weight Log
                            </a>
                        </div>
                        <div class="p-6">
                            @forelse ($client->weightLogs as $log)
                                <div class="mb-4 pb-4 border-b border-gray-200 last:border-b-0">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-medium font-medium text-gray-900">{{ $log->date->format('M d, Y') }}</p>
                                            <div class="flex space-x-4 text-sm text-gray-600">
                                                @if($log->morning_weight)
                                                    <span>Morning: {{ $log->morning_weight }}kg</span>
                                                @endif
                                                @if($log->night_weight)
                                                    <span>Night: {{ $log->night_weight }}kg</span>
                                                @endif
                                                @if($log->average_weight)
                                                    <span class="font-medium">Average: {{ $log->average_weight }}kg</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">No weight logs yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
