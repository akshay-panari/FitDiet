<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;
use App\Models\Client;
use App\Models\DietPlanDay;
use App\Models\DietPlanMeal;
use Barryvdh\DomPDF\Facade\PDF;

class DietPlanController extends Controller
{
    public function index()
    {
        $dietPlans = DietPlan::with('client')->latest()->paginate(10);
        return view('diet-plans.index', compact('dietPlans'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('diet-plans.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'instructions' => 'nullable|string',
        ]);

        $dietPlan = DietPlan::create($validated);

        // Auto-generate days between start_date and end_date
        $currentDate = $dietPlan->start_date->copy();
        $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        while ($currentDate <= $dietPlan->end_date) {
            DietPlanDay::create([
                'diet_plan_id' => $dietPlan->id,
                'date' => $currentDate,
                'day_name' => $dayNames[$currentDate->dayOfWeekIso - 1],
            ]);
            $currentDate->addDay();
        }

        return redirect()->route('diet-plans.show', $dietPlan)
            ->with('success', 'Diet plan created successfully. Days have been generated.');
    }

    public function show(DietPlan $diet_plan)
    {
        $diet_plan->load(['client', 'dietPlanDays.meals']);
        return view('diet-plans.show', ['dietPlan' => $diet_plan]);
    }

    public function edit(DietPlan $diet_plan)
    {
        $clients = Client::all();
        return view('diet-plans.edit', ['dietPlan' => $diet_plan, 'clients' => $clients]);
    }

    public function update(Request $request, DietPlan $diet_plan)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'instructions' => 'nullable|string',
            'status' => 'required|in:active,completed',
        ]);

        // Store the original days with their meals to preserve them
        $originalDays = $diet_plan->dietPlanDays->map(function($day) {
            return [
                'original_date' => $day->date,
                'day_name' => $day->day_name,
                'meals' => $day->meals->map(function($meal) {
                    return [
                        'time' => $meal->time,
                        'meal_title' => $meal->meal_title,
                        'description' => $meal->description,
                        'remark' => $meal->remark,
                        'meal_template_id' => $meal->meal_template_id,
                        'meal_sub_template_id' => $meal->meal_sub_template_id,
                    ];
                })->toArray(),
            ];
        })->toArray();

        // Update the diet plan
        $diet_plan->update($validated);

        // Delete all existing days to avoid unique constraint violations
        DietPlanDay::where('diet_plan_id', $diet_plan->id)->delete();

        // Recreate days with new dates and preserve meals
        $currentDate = $diet_plan->start_date->copy();
        $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        foreach ($originalDays as $index => $originalDay) {
            $newDate = $currentDate->copy();
            $newDayName = $dayNames[$newDate->dayOfWeekIso - 1];
            
            // Create the new day
            $newDay = DietPlanDay::create([
                'diet_plan_id' => $diet_plan->id,
                'date' => $newDate,
                'day_name' => $newDayName,
            ]);

            // Recreate meals for this day
            foreach ($originalDay['meals'] as $mealData) {
                DietPlanMeal::create([
                    'diet_plan_day_id' => $newDay->id,
                    'time' => $mealData['time'],
                    'meal_title' => $mealData['meal_title'],
                    'description' => $mealData['description'],
                    'remark' => $mealData['remark'],
                    'meal_template_id' => $mealData['meal_template_id'],
                    'meal_sub_template_id' => $mealData['meal_sub_template_id'],
                ]);
            }

            $currentDate->addDay();
        }

        return redirect()->route('diet-plans.show', $diet_plan)
            ->with('success', 'Diet plan updated successfully. Internal day dates have been adjusted.');
    }

    public function destroy(DietPlan $diet_plan)
    {
        $diet_plan->delete();

        return redirect()->route('diet-plans.index')
            ->with('success', 'Diet plan deleted successfully.');
    }

    public function generatePdf(DietPlan $diet_plan)
    {
        // Load all necessary relationships with explicit eager loading
        $diet_plan = DietPlan::with(['client', 'dietPlanDays.meals'])->find($diet_plan->id);
        
        // Double-check if we have the data
        if (!$diet_plan) {
            abort(404, 'Diet plan not found.');
        }

        // Configure PDF
        PDF::setOptions([
            'defaultFont' => 'Arial',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);
        
        $pdf = PDF::loadView('diet-plans.pdf-simple', ['dietPlan' => $diet_plan]);
        
        $clientName = $diet_plan->client ? $diet_plan->client->full_name : 'unknown-client';
        $startDate = $diet_plan->start_date ? $diet_plan->start_date->format('Y-m-d') : 'no-date';
        $filename = 'diet-plan-' . str_replace(' ', '-', $clientName) . '-' . $startDate . '.pdf';
        
        // Return the PDF for download
        return $pdf->download($filename);
    }
}
