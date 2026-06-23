<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\DietPlan;
use App\Models\WeightLog;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_clients' => Client::count(),
            'active_diet_plans' => DietPlan::where('status', 'active')->count(),
            'pending_weight_logs_today' => WeightLog::whereDate('date', today())->count(),
        ];

        $recentActivity = [
            'latest_clients' => Client::latest()->take(5)->get(),
            'latest_diet_plans' => DietPlan::with('client')->latest()->take(5)->get(),
            'latest_weight_logs' => WeightLog::with('client')->latest()->take(5)->get(),
        ];

        return view('livewire.dashboard', compact('stats', 'recentActivity'));
    }
}
