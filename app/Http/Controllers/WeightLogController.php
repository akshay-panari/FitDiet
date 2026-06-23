<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;
use App\Models\Client;

class WeightLogController extends Controller
{
    public function index()
    {
        $weightLogs = WeightLog::with('client')->latest()->paginate(10);
        return view('weight-logs.index', compact('weightLogs'));
    }

    public function create()
    {
        $clients = Client::all();
        $selectedClientId = request('client_id');
        return view('weight-logs.create', compact('clients', 'selectedClientId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'morning_weight' => 'nullable|numeric|min:20|max:500',
            'night_weight' => 'nullable|numeric|min:20|max:500',
        ]);

        // Ensure at least one weight is provided
        if (!$validated['morning_weight'] && !$validated['night_weight']) {
            return back()->withErrors(['weight' => 'At least morning weight or night weight must be provided.']);
        }

        WeightLog::create($validated);

        return redirect()->route('weight-logs.index')
            ->with('success', 'Weight log added successfully.');
    }

    public function show(WeightLog $weightLog)
    {
        return view('weight-logs.show', compact('weightLog'));
    }

    public function edit(WeightLog $weightLog)
    {
        $clients = Client::all();
        return view('weight-logs.edit', compact('weightLog', 'clients'));
    }

    public function update(Request $request, WeightLog $weightLog)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'morning_weight' => 'nullable|numeric|min:20|max:500',
            'night_weight' => 'nullable|numeric|min:20|max:500',
        ]);

        // Ensure at least one weight is provided
        if (!$validated['morning_weight'] && !$validated['night_weight']) {
            return back()->withErrors(['weight' => 'At least morning weight or night weight must be provided.']);
        }

        $weightLog->update($validated);

        return redirect()->route('weight-logs.index')
            ->with('success', 'Weight log updated successfully.');
    }

    public function destroy(WeightLog $weightLog)
    {
        $weightLog->delete();

        return redirect()->route('weight-logs.index')
            ->with('success', 'Weight log deleted successfully.');
    }
}
