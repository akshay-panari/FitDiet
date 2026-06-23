<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Diet Plan Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('diet-plans.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Diet Plans</a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $dietPlan->title }}</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('diet-plans.pdf', $dietPlan) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        📄 Download PDF
                    </a>
                    <a href="{{ route('diet-plans.edit', $dietPlan) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Plan
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Plan Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Plan Information</h2>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Client</dt>
                                <dd class="text-sm text-gray-900">
                                    <a href="{{ route('clients.show', $dietPlan->client) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $dietPlan->client->full_name }}
                                    </a>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="text-sm text-gray-900">{{ $dietPlan->start_date->format('M d, Y') }} - {{ $dietPlan->end_date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dietPlan->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $dietPlan->status }}
                                    </span>
                                </dd>
                            </div>
                            @if($dietPlan->instructions)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Instructions</dt>
                                <dd class="text-sm text-gray-900">{{ $dietPlan->instructions }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Diet Plan Days and Meals -->
                <div class="lg:col-span-2">
                    <livewire:diet-plan-meals :diet-plan="$dietPlan" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
