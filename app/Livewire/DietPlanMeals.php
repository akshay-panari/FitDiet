<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DietPlan;
use App\Models\DietPlanDay;
use App\Models\DietPlanMeal;
use App\Models\MealTemplate;

class DietPlanMeals extends Component
{
    public $dietPlan;
    public $dietPlanDays;
    public $mealTemplates;
    public $selectedDayId;
    public $showAddMeal = false;
    
    // Form fields
    public $time;
    public $meal_title;
    public $description;
    public $remark;
    public $selectedTemplate = '';

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

    public function selectTemplate($templateId)
    {
        $template = MealTemplate::find($templateId);
        if ($template) {
            $this->description = $template->description;
            $this->remark = $template->default_remark;
            $this->selectedTemplate = $templateId;
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

    private function resetForm()
    {
        $this->time = '';
        $this->meal_title = '';
        $this->description = '';
        $this->remark = '';
        $this->selectedTemplate = '';
    }
}
