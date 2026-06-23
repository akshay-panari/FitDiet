<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meal Templates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Meal Templates</h1>
                <a href="{{ route('meal-templates.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Template
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @forelse ($templates as $template)
                        <li>
                            <a href="{{ route('meal-templates.show', $template) }}" class="block hover:bg-gray-50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                                            <div class="text-sm text-gray-500 mt-1">{{ Str::limit($template->description, 100) }}</div>
                                            @if($template->default_remark)
                                                <div class="text-xs text-gray-400 mt-1">Note: {{ Str::limit($template->default_remark, 50) }}</div>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ route('meal-templates.edit', $template) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('meal-templates.destroy', $template) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-8 text-center text-gray-500">
                            No meal templates found. <a href="{{ route('meal-templates.create') }}" class="text-blue-600 hover:text-blue-900">Create your first template</a>.
                        </li>
                    @endforelse
                </ul>
            </div>

            <div class="mt-6">
                {{ $templates->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
