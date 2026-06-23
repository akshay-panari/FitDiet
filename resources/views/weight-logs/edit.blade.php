<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Weight Log') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('weight-logs.show', $weightLog) }}" class="text-gray-600 hover:text-gray-900">← Back to Weight Log</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('weight-logs.update', $weightLog) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                        <select name="client_id" id="client_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $weightLog->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->full_name }} ({{ $client->starting_weight }}kg → {{ $client->goal_weight }}kg)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $weightLog->date->format('Y-m-d')) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="morning_weight" class="block text-sm font-medium text-gray-700">Morning Weight (kg)</label>
                            <input type="number" name="morning_weight" id="morning_weight" value="{{ old('morning_weight', $weightLog->morning_weight) }}" 
                                step="0.1" min="20" max="500"
                                placeholder="e.g., 75.5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="night_weight" class="block text-sm font-medium text-gray-700">Night Weight (kg)</label>
                            <input type="number" name="night_weight" id="night_weight" value="{{ old('night_weight', $weightLog->night_weight) }}" 
                                step="0.1" min="20" max="500"
                                placeholder="e.g., 74.8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('weight-logs.show', $weightLog) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Weight Log
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
