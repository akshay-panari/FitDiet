<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weight Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Weight Logs</h1>
                <a href="{{ route('weight-logs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Weight Log
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse ($weightLogs as $log)
                        <li>
                            <a href="{{ route('weight-logs.show', $log) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                                    <span class="text-white font-medium">{{ substr($log->client->full_name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $log->client->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $log->date->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                @if($log->morning_weight)
                                                    <div class="text-sm text-gray-600">Morning: {{ $log->morning_weight }}kg</div>
                                                @endif
                                                @if($log->night_weight)
                                                    <div class="text-sm text-gray-600">Night: {{ $log->night_weight }}kg</div>
                                                @endif
                                                @if($log->average_weight)
                                                    <div class="text-sm font-medium text-gray-900">Avg: {{ $log->average_weight }}kg</div>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('weight-logs.edit', $log) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('weight-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-8 text-center text-gray-500">
                            No weight logs found. <a href="{{ route('weight-logs.create') }}" class="text-blue-600 hover:text-blue-900">Add your first weight log</a>.
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-6">
                {{ $weightLogs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
