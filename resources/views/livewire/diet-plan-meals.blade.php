<div>
    <!-- Diet Plan Days and Meals -->
    <div class="bg-white shadow sm:rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900">Daily Meal Plan</h2>
            <span class="text-sm text-gray-500">{{ $dietPlan->dietPlanDays->count() }} days</span>
        </div>
        <div class="divide-y divide-gray-200">
            @forelse ($dietPlanDays as $day)
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $day->day_name }}</h3>
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-500">{{ $day->date->format('M d, Y') }}</span>
                            <button wire:click="showEditDayForm({{ $day->id }})" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Edit Day
                            </button>
                            <button wire:click="showAddMealForm({{ $day->id }})" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Meal
                            </button>
                        </div>
                    </div>
                    
                    @if($day->meals->count() > 0)
                        <div class="space-y-3">
                            @foreach ($day->meals->sortBy('time') as $meal)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm font-medium text-gray-900 bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                {{ $meal->time->format('H:i') }}
                                            </span>
                                            @if($meal->meal_title)
                                                <h4 class="font-medium text-gray-900">{{ $meal->meal_title }}</h4>
                                            @endif
                                        </div>
                                        <div class="flex space-x-3">
                                            <button wire:click="showEditMealForm({{ $meal->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Edit
                                            </button>
                                            <button wire:click="deleteMeal({{ $meal->id }})" 
                                                    onclick="return confirm('Delete this meal?')"
                                                    class="text-red-600 hover:text-red-900 text-sm">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700 mb-2">{{ $meal->description }}</p>
                                    @if($meal->remark)
                                        <p class="text-xs text-gray-500 italic">Note: {{ $meal->remark }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-4">No meals added for this day yet.</p>
                            <button wire:click="showAddMealForm({{ $day->id }})" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                                Add Meal
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    No days found for this diet plan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add Meal Modal -->
    @if($showAddMeal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="hideAddMealForm">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add Meal</h3>
                    
                    <form wire:submit="addMeal">
                        <div class="space-y-4">
                            <!-- Meal Template Selection -->
                            @if($mealTemplates->count() > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Use Template (Optional)</label>
                                    <select wire:model="selectedTemplate" wire:change="selectTemplate(selectedTemplate)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a template...</option>
                                        @foreach ($mealTemplates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Sub-Template Selection -->
                            @if($selectedTemplate && count($subTemplates) > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Select Sub-Template (Optional)</label>
                                    <select wire:model="selectedSubTemplate" wire:change="selectSubTemplate(selectedSubTemplate)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a sub-template...</option>
                                        @foreach ($subTemplates as $subTemplate)
                                            <option value="{{ $subTemplate->id }}">{{ $subTemplate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Time</label>
                                <input type="time" wire:model="time" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('time')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Meal Title (Optional)</label>
                                <input type="text" wire:model="meal_title"
                                       placeholder="e.g., Breakfast, Lunch, Dinner"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('meal_title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea wire:model="description" rows="3" required
                                          placeholder="Describe the meal..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remark (Optional)</label>
                                <textarea wire:model="remark" rows="2"
                                          placeholder="Any additional notes..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('remark')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="hideAddMealForm"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add Meal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Meal Modal -->
    @if($showEditMeal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="hideEditMealForm">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Meal</h3>
                    
                    <form wire:submit="updateMeal">
                        <div class="space-y-4">
                            <!-- Meal Template Selection -->
                            @if($mealTemplates->count() > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Use Template (Optional)</label>
                                    <select wire:model="selectedTemplate" wire:change="selectTemplate(selectedTemplate)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a template...</option>
                                        @foreach ($mealTemplates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Sub-Template Selection -->
                            @if($selectedTemplate && count($subTemplates) > 0)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Select Sub-Template (Optional)</label>
                                    <select wire:model="selectedSubTemplate" wire:change="selectSubTemplate(selectedSubTemplate)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Select a sub-template...</option>
                                        @foreach ($subTemplates as $subTemplate)
                                            <option value="{{ $subTemplate->id }}">{{ $subTemplate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Time</label>
                                <input type="time" wire:model="time" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('time')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Meal Title (Optional)</label>
                                <input type="text" wire:model="meal_title"
                                       placeholder="e.g., Breakfast, Lunch, Dinner"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('meal_title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Description *</label>
                                <textarea wire:model="description" rows="3" required
                                          placeholder="Describe the meal..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('description')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Remark (Optional)</label>
                                <textarea wire:model="remark" rows="2"
                                          placeholder="Any additional notes..."
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('remark')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="hideEditMealForm"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Meal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Day Modal -->
    @if($showEditDay)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="hideEditDayForm">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Day</h3>
                    
                    <form wire:submit="updateDay">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" wire:model="day_date" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('day_date')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Day Name</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>The day name will be automatically calculated from the selected date.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" wire:click="hideEditDayForm"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Day
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
