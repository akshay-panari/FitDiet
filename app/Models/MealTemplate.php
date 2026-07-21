<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'default_remark',
    ];

    public function subTemplates()
    {
        return $this->hasMany(MealSubTemplate::class);
    }
}
