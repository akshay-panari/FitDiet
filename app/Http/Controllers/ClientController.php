<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\WeightLog;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|in:male,female,other',
            'height' => 'required|numeric|min:50|max:300',
            'starting_weight' => 'required|numeric|min:20|max:500',
            'goal_weight' => 'required|numeric|min:20|max:500',
            'medical_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load(['dietPlans', 'weightLogs' => function($query) {
            $query->latest()->take(30);
        }]);
        
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|in:male,female,other',
            'height' => 'required|numeric|min:50|max:300',
            'starting_weight' => 'required|numeric|min:20|max:500',
            'goal_weight' => 'required|numeric|min:20|max:500',
            'medical_conditions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }

    public function progress(Client $client)
    {
        $weightLogs = $client->weightLogs()
            ->orderBy('date')
            ->get();

        $chartData = [
            'labels' => $weightLogs->pluck('date')->map(fn($date) => $date->format('M d')),
            'datasets' => [
                [
                    'label' => 'Weight Progress',
                    'data' => $weightLogs->pluck('average_weight'),
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                ]
            ]
        ];

        return view('clients.progress', compact('client', 'chartData'));
    }
}
