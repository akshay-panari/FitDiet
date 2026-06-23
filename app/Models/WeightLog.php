<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeightLog extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'morning_weight',
        'night_weight',
    ];

    protected $casts = [
        'date' => 'date',
        'morning_weight' => 'decimal:2',
        'night_weight' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getAverageWeightAttribute(): ?float
    {
        if ($this->morning_weight && $this->night_weight) {
            return ($this->morning_weight + $this->night_weight) / 2;
        }
        
        return $this->morning_weight ?? $this->night_weight;
    }
}
