<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietPlanDay extends Model
{
    protected $fillable = [
        'diet_plan_id',
        'date',
        'day_name',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function dietPlan(): BelongsTo
    {
        return $this->belongsTo(DietPlan::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(DietPlanMeal::class)->orderBy('time');
    }
}
