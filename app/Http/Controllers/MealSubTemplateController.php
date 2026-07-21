<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MealSubTemplate;
use App\Models\MealTemplate;

class MealSubTemplateController extends Controller
{
    public function index()
    {
        $subTemplates = MealSubTemplate::with('mealTemplate')->latest()->paginate(10);
        return view('meal-sub-templates.index', compact('subTemplates'));
    }

    public function create()
    {
        $mealTemplates = MealTemplate::all();
        return view('meal-sub-templates.create', compact('mealTemplates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_template_id' => 'required|exists:meal_templates,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'time' => 'nullable|date_format:H:i',
            'default_remark' => 'nullable|string',
        ]);

        MealSubTemplate::create($validated);

        return redirect()->route('meal-sub-templates.index')
            ->with('success', 'Sub-template created successfully.');
    }

    public function show(MealSubTemplate $meal_sub_template)
    {
        $meal_sub_template->load('mealTemplate');
        return view('meal-sub-templates.show', ['subTemplate' => $meal_sub_template]);
    }

    public function edit(MealSubTemplate $meal_sub_template)
    {
        $mealTemplates = MealTemplate::all();
        return view('meal-sub-templates.edit', [
            'subTemplate' => $meal_sub_template,
            'mealTemplates' => $mealTemplates
        ]);
    }

    public function update(Request $request, MealSubTemplate $meal_sub_template)
    {
        $validated = $request->validate([
            'meal_template_id' => 'required|exists:meal_templates,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'time' => 'nullable|date_format:H:i',
            'default_remark' => 'nullable|string',
        ]);

        $meal_sub_template->update($validated);

        return redirect()->route('meal-sub-templates.index')
            ->with('success', 'Sub-template updated successfully.');
    }

    public function destroy(MealSubTemplate $meal_sub_template)
    {
        $meal_sub_template->delete();

        return redirect()->route('meal-sub-templates.index')
            ->with('success', 'Sub-template deleted successfully.');
    }
}
