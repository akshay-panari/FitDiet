<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Meal Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('meal-templates.show', $mealTemplate) }}" class="text-gray-600 hover:text-gray-900">← Back to Template</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('meal-templates.update', $mealTemplate) }}" method="POST" class="p-6 space-y-6">
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
                        <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $mealTemplate->name) }}" required
                            placeholder="e.g., High Protein Breakfast, Low Carb Lunch"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required
                            placeholder="Describe the meal in detail (ingredients, preparation, etc.)..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $mealTemplate->description) }}</textarea>
                    </div>

                    <div>
                        <label for="default_remark" class="block text-sm font-medium text-gray-700">Default Remark (Optional)</label>
                        <textarea name="default_remark" id="default_remark" rows="2"
                            placeholder="Any notes or tips that will be included by default..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('default_remark', $mealTemplate->default_remark) }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('meal-templates.show', $mealTemplate) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
