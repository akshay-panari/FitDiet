<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Diet Plan - {{ $dietPlan->client->full_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }
        .header h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        .info-section h3 {
            font-size: 14px;
            margin: 0 0 10px 0;
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .info-item {
            margin-bottom: 5px;
        }
        .info-item strong {
            color: #333;
        }
        .day-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .day-header {
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
            font-weight: bold;
            font-size: 14px;
        }
        .meal-item {
            margin: 10px 0;
            padding: 10px;
            border-left: 3px solid #007bff;
            background-color: #f8f9fa;
        }
        .meal-time {
            font-weight: bold;
            color: #007bff;
            font-size: 12px;
        }
        .meal-title {
            font-weight: bold;
            margin: 2px 0;
            font-size: 13px;
        }
        .meal-description {
            margin: 5px 0;
        }
        .meal-remark {
            font-style: italic;
            color: #666;
            font-size: 11px;
        }
        .no-meals {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .day-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Diet Plan</h1>
        <h2>{{ $dietPlan->title }}</h2>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <div class="info-section">
        <h3>Client Information</h3>
        <div class="info-grid">
            <div class="info-item"><strong>Name:</strong> {{ $dietPlan->client->full_name ?? 'N/A' }}</div>
            <div class="info-item"><strong>Age:</strong> {{ $dietPlan->client->age ?? 'N/A' }} years</div>
            <div class="info-item"><strong>Gender:</strong> {{ $dietPlan->client->gender ? ucfirst($dietPlan->client->gender) : 'N/A' }}</div>
            <div class="info-item"><strong>Height:</strong> {{ $dietPlan->client->height ?? 'N/A' }} cm</div>
            <div class="info-item"><strong>Starting Weight:</strong> {{ $dietPlan->client->starting_weight ?? 'N/A' }} kg</div>
            <div class="info-item"><strong>Goal Weight:</strong> {{ $dietPlan->client->goal_weight ?? 'N/A' }} kg</div>
            <div class="info-item"><strong>Phone:</strong> {{ $dietPlan->client->phone ?? 'N/A' }}</div>
            @if($dietPlan->client && $dietPlan->client->email)
                <div class="info-item"><strong>Email:</strong> {{ $dietPlan->client->email }}</div>
            @endif
        </div>
        @if($dietPlan->client && $dietPlan->client->medical_conditions)
            <div class="info-item" style="margin-top: 10px;"><strong>Medical Conditions:</strong> {{ $dietPlan->client->medical_conditions }}</div>
        @endif
    </div>

    <div class="info-section">
        <h3>Plan Details</h3>
        <div class="info-grid">
            <div class="info-item"><strong>Duration:</strong> {{ $dietPlan->start_date->format('M d, Y') }} - {{ $dietPlan->end_date->format('M d, Y') }}</div>
            <div class="info-item"><strong>Status:</strong> {{ ucfirst($dietPlan->status) }}</div>
            <div class="info-item"><strong>Total Days:</strong> {{ $dietPlan->dietPlanDays->count() }}</div>
        </div>
        @if($dietPlan->instructions)
            <div class="info-item" style="margin-top: 10px;"><strong>Instructions:</strong> {{ $dietPlan->instructions }}</div>
        @endif
    </div>

    <div class="meal-plan">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Daily Meal Plan</h3>
        
        @forelse ($dietPlan->dietPlanDays->sortBy('date') as $day)
            <div class="day-section">
                <div class="day-header">
                    {{ $day->day_name }} - {{ $day->date->format('M d, Y') }}
                </div>
                
                @if($day->meals->count() > 0)
                    @foreach ($day->meals->sortBy('time') as $meal)
                        <div class="meal-item">
                            <div class="meal-time">{{ $meal->time->format('H:i') }}</div>
                            @if($meal->meal_title)
                                <div class="meal-title">{{ $meal->meal_title }}</div>
                            @endif
                            <div class="meal-description">{{ $meal->description }}</div>
                            @if($meal->remark)
                                <div class="meal-remark">Note: {{ $meal->remark }}</div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="no-meals">
                        No meals scheduled for this day.
                    </div>
                @endif
            </div>
        @empty
            <div class="no-meals">
                No days found in this diet plan.
            </div>
        @endforelse
    </div>

    <div class="footer">
        <p>This diet plan was generated using FitDiet Management System.</p>
        <p>For questions or modifications, please contact your dietitian.</p>
    </div>
</body>
</html>
