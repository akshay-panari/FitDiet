<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diet Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Diet Plans</h1>
                <a href="{{ route('diet-plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create New Plan
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse ($dietPlans as $plan)
                        <li>
                            <a href="{{ route('diet-plans.show', $plan) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $plan->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $plan->client->full_name }} • {{ $plan->start_date->format('M d, Y') }} - {{ $plan->end_date->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $plan->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $plan->status }}
                                            </span>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('diet-plans.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <form action="{{ route('diet-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                            No diet plans found. <a href="{{ route('diet-plans.create') }}" class="text-blue-600 hover:text-blue-900">Create your first diet plan</a>.
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-6">
                {{ $dietPlans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
