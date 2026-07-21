<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealSubTemplate extends Model
{
    protected $fillable = [
        'meal_template_id',
        'name',
        'description',
        'time',
        'default_remark',
    ];

    protected $casts = [
        'time' => 'datetime:H:i',
    ];

    public function mealTemplate()
    {
        return $this->belongsTo(MealTemplate::class);
    }
}
