<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DietPlan extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'start_date',
        'end_date',
        'instructions',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function dietPlanDays(): HasMany
    {
        return $this->hasMany(DietPlanDay::class)->orderBy('date');
    }

    public function meals(): HasMany
    {
        return $this->hasManyThrough(DietPlanMeal::class, DietPlanDay::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
