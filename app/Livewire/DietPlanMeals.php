<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DietPlan;
use App\Models\DietPlanDay;
use App\Models\DietPlanMeal;
use App\Models\MealTemplate;
use App\Models\MealSubTemplate;

class DietPlanMeals extends Component
{
    public $dietPlan;
    public $dietPlanDays;
    public $mealTemplates;
    public $selectedDayId;
    public $showAddMeal = false;
    public $showEditMeal = false;
    public $showEditDay = false;
    public $editingMealId = null;
    public $editingDayId = null;
    
    // Form fields
    public $time;
    public $meal_title;
    public $description;
    public $remark;
    public $selectedTemplate = '';
    public $selectedSubTemplate = '';
    public $subTemplates = [];
    public $day_date;

    protected $rules = [
        'time' => 'required|date_format:H:i',
        'description' => 'required|string',
        'meal_title' => 'nullable|string|max:255',
        'remark' => 'nullable|string',
    ];

    public function mount(DietPlan $dietPlan)
    {
        $this->dietPlan = $dietPlan->load(['dietPlanDays.meals']);
        $this->dietPlanDays = $dietPlan->dietPlanDays->sortBy('date');
        $this->mealTemplates = MealTemplate::all();
    }

    public function render()
    {
        return view('livewire.diet-plan-meals');
    }

    public function showAddMealForm($dayId)
    {
        $this->selectedDayId = $dayId;
        $this->showAddMeal = true;
        $this->resetForm();
    }

    public function hideAddMealForm()
    {
        $this->showAddMeal = false;
        $this->resetForm();
    }

    public function showEditMealForm($mealId)
    {
        $meal = DietPlanMeal::find($mealId);
        if ($meal) {
            $this->editingMealId = $mealId;
            $this->time = $meal->time->format('H:i');
            $this->meal_title = $meal->meal_title;
            $this->description = $meal->description;
            $this->remark = $meal->remark;
            $this->selectedTemplate = '';
            $this->showEditMeal = true;
        }
    }

    public function hideEditMealForm()
    {
        $this->showEditMeal = false;
        $this->editingMealId = null;
        $this->resetForm();
    }

    public function showEditDayForm($dayId)
    {
        $day = DietPlanDay::find($dayId);
        if ($day) {
            $this->editingDayId = $dayId;
            $this->day_date = $day->date->format('Y-m-d');
            $this->showEditDay = true;
        }
    }

    public function hideEditDayForm()
    {
        $this->showEditDay = false;
        $this->editingDayId = null;
        $this->day_date = '';
    }

    public function updateDay()
    {
        $this->validate([
            'day_date' => 'required|date',
        ]);

        $day = DietPlanDay::find($this->editingDayId);
        if ($day) {
            // Calculate day name from date
            $date = \Carbon\Carbon::parse($this->day_date);
            $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $calculatedDayName = $dayNames[$date->dayOfWeekIso - 1];

            $day->update([
                'date' => $this->day_date,
                'day_name' => $calculatedDayName,
            ]);

            $this->hideEditDayForm();
            
            // Refresh the diet plan data
            $this->dietPlan->refresh();
            $this->dietPlanDays = $this->dietPlan->dietPlanDays->sortBy('date');
            
            $this->dispatch('dayUpdated');
        }
    }

    public function selectTemplate($templateId)
    {
        $template = MealTemplate::find($templateId);
        if ($template) {
            $this->selectedTemplate = $templateId;
            $this->selectedSubTemplate = '';
            $this->subTemplates = $template->subTemplates;
            
            // Reset meal fields when template changes
            $this->time = '';
            $this->description = '';
            $this->remark = '';
        }
    }

    public function selectSubTemplate($subTemplateId)
    {
        $subTemplate = MealSubTemplate::find($subTemplateId);
        if ($subTemplate) {
            $this->selectedSubTemplate = $subTemplateId;
            $this->time = $subTemplate->time ? $subTemplate->time->format('H:i') : '';
            $this->meal_title = $subTemplate->name;
            $this->description = $subTemplate->description;
            $this->remark = $subTemplate->default_remark;
        }
    }

    public function addMeal()
    {
        $this->validate();

        $day = DietPlanDay::find($this->selectedDayId);
        
        DietPlanMeal::create([
            'diet_plan_day_id' => $this->selectedDayId,
            'time' => $this->time,
            'meal_title' => $this->meal_title,
            'description' => $this->description,
            'remark' => $this->remark,
            'meal_template_id' => $this->selectedTemplate ?: null,
            'meal_sub_template_id' => $this->selectedSubTemplate ?: null,
        ]);

        $this->hideAddMealForm();
        
        // Refresh the diet plan data
        $this->dietPlan->refresh();
        $this->dietPlanDays = $this->dietPlan->dietPlanDays->sortBy('date');
        
        $this->dispatch('mealAdded');
    }

    public function deleteMeal($mealId)
    {
        $meal = DietPlanMeal::find($mealId);
        if ($meal) {
            $meal->delete();
            $this->dietPlan->refresh();
            $this->dietPlanDays = $this->dietPlan->dietPlanDays->sortBy('date');
        }
    }

    public function updateMeal()
    {
        $this->validate();

        $meal = DietPlanMeal::find($this->editingMealId);
        if ($meal) {
            $meal->update([
                'time' => $this->time,
                'meal_title' => $this->meal_title,
                'description' => $this->description,
                'remark' => $this->remark,
            ]);

            $this->hideEditMealForm();
            
            // Refresh the diet plan data
            $this->dietPlan->refresh();
            $this->dietPlanDays = $this->dietPlan->dietPlanDays->sortBy('date');
            
            $this->dispatch('mealUpdated');
        }
    }

    private function resetForm()
    {
        $this->time = '';
        $this->meal_title = '';
        $this->description = '';
        $this->remark = '';
        $this->selectedTemplate = '';
        $this->selectedSubTemplate = '';
        $this->subTemplates = [];
    }
}
