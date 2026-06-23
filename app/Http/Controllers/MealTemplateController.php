<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealTemplate;

class MealTemplateController extends Controller
{
    public function index()
    {
        $templates = MealTemplate::latest()->paginate(10);
        return view('meal-templates.index', compact('templates'));
    }

    public function create()
    {
        return view('meal-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'default_remark' => 'nullable|string',
        ]);

        MealTemplate::create($validated);

        return redirect()->route('meal-templates.index')
            ->with('success', 'Meal template created successfully.');
    }

    public function show(MealTemplate $mealTemplate)
    {
        return view('meal-templates.show', compact('mealTemplate'));
    }

    public function edit(MealTemplate $mealTemplate)
    {
        return view('meal-templates.edit', compact('mealTemplate'));
    }

    public function update(Request $request, MealTemplate $mealTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'default_remark' => 'nullable|string',
        ]);

        $mealTemplate->update($validated);

        return redirect()->route('meal-templates.index')
            ->with('success', 'Meal template updated successfully.');
    }

    public function destroy(MealTemplate $mealTemplate)
    {
        $mealTemplate->delete();

        return redirect()->route('meal-templates.index')
            ->with('success', 'Meal template deleted successfully.');
    }
}
