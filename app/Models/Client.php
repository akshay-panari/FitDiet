<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'age',
        'gender',
        'height',
        'starting_weight',
        'goal_weight',
        'medical_conditions',
        'notes',
    ];

    protected $casts = [
        'height' => 'decimal:2',
        'starting_weight' => 'decimal:2',
        'goal_weight' => 'decimal:2',
    ];

    public function dietPlans(): HasMany
    {
        return $this->hasMany(DietPlan::class);
    }

    public function weightLogs(): HasMany
    {
        return $this->hasMany(WeightLog::class)->orderBy('date');
    }

    public function latestWeightLog()
    {
        return $this->hasOne(WeightLog::class)->latest('date');
    }
}
