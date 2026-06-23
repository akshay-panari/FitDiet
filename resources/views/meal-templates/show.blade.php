<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meal Template Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('meal-templates.index') }}" class="text-gray-600 hover:text-gray-900">← Back to Meal Templates</a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $mealTemplate->name }}</h1>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('meal-templates.edit', $mealTemplate) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Template
                    </a>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Template Name</h3>
                            <p class="text-gray-700">{{ $mealTemplate->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $mealTemplate->description }}</p>
                            </div>
                        </div>

                        @if($mealTemplate->default_remark)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Default Remark</h3>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $mealTemplate->default_remark }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Usage Information</h3>
                            <p class="text-sm text-gray-600">This template can be selected when adding meals to diet plans. The description and remark will be automatically filled in the meal form.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
