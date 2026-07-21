<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DietPlanController;
use App\Http\Controllers\MealTemplateController;
use App\Http\Controllers\MealSubTemplateController;
use App\Http\Controllers\WeightLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client Management
    Route::resource('clients', ClientController::class);
    Route::get('/clients/{client}/progress', [ClientController::class, 'progress'])->name('clients.progress');

    // Diet Plans
    Route::resource('diet-plans', DietPlanController::class);
    Route::get('/diet-plans/{diet_plan}/pdf', [DietPlanController::class, 'generatePdf'])->name('diet-plans.pdf');

    // Meal Templates
    Route::resource('meal-templates', MealTemplateController::class);
    Route::resource('meal-sub-templates', MealSubTemplateController::class);

    // Weight Logs
    Route::resource('weight-logs', WeightLogController::class);
});

require __DIR__.'/auth.php';
