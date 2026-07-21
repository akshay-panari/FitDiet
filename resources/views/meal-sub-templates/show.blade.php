@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Sub-Template Details</h1>
            <a href="{{ route('meal-sub-templates.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                Back to List
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500">Name</label>
                    <p class="mt-1 text-lg text-gray-900">{{ $subTemplate->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Parent Template</label>
                    <p class="mt-1 text-gray-900">{{ $subTemplate->mealTemplate->name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Time</label>
                    <p class="mt-1 text-gray-900">{{ $subTemplate->time ? $subTemplate->time->format('H:i') : 'Not set' }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-500">Description</label>
                    <p class="mt-1 text-gray-900">{{ $subTemplate->description }}</p>
                </div>

                @if($subTemplate->default_remark)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Default Remark</label>
                        <p class="mt-1 text-gray-900 italic">{{ $subTemplate->default_remark }}</p>
                    </div>
                @endif
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t">
                <a href="{{ route('meal-sub-templates.edit', $subTemplate) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
