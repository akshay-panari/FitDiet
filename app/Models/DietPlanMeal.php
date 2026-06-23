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
}
