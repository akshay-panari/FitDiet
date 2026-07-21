<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DietPlanMeal extends Model
{
    protected $fillable = [
        'diet_plan_day_id',
        'time',
        'meal_title',
        'description',
        'remark',
        'meal_template_id',
        'meal_sub_template_id',
    ];

    protected $casts = [
        'time' => 'datetime:H:i:s',
    ];

    public function dietPlanDay(): BelongsTo
    {
        return $this->belongsTo(DietPlanDay::class);
    }

    public function dietPlan(): BelongsTo
    {
        return $this->dietPlanDay->dietPlan;
    }

    public function mealTemplate(): BelongsTo
    {
        return $this->belongsTo(MealTemplate::class);
    }

    public function mealSubTemplate(): BelongsTo
    {
        return $this->belongsTo(MealSubTemplate::class);
    }
}
