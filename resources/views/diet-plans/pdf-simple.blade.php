<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Diet Plan - {{ $dietPlan->client ? $dietPlan->client->full_name : 'Unknown' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        .meal { margin: 10px 0; padding: 10px; border-left: 3px solid #007bff; background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Diet Plan</h1>
        <h2>{{ $dietPlan->title }}</h2>
        <p>Client: {{ $dietPlan->client ? $dietPlan->client->full_name : 'N/A' }}</p>
        <p>Duration: {{ $dietPlan->start_date ? $dietPlan->start_date->format('M d, Y') : 'N/A' }} - {{ $dietPlan->end_date ? $dietPlan->end_date->format('M d, Y') : 'N/A' }}</p>
    </div>

    <div class="info">
        <h3>Client Information</h3>
        @if($dietPlan->client)
            <p>Age: {{ $dietPlan->client->age ?? 'N/A' }} years</p>
            <p>Gender: {{ $dietPlan->client->gender ? ucfirst($dietPlan->client->gender) : 'N/A' }}</p>
            <p>Starting Weight: {{ $dietPlan->client->starting_weight ?? 'N/A' }} kg</p>
            <p>Goal Weight: {{ $dietPlan->client->goal_weight ?? 'N/A' }} kg</p>
        @else
            <p>Client information not available.</p>
        @endif
    </div>

    <div>
        <h3>Daily Meal Plan</h3>
        @forelse ($dietPlan->dietPlanDays->sortBy('date') as $day)
            <h4>{{ $day->day_name ?? 'Day' }} - {{ $day->date ? $day->date->format('M d, Y') : 'N/A' }}</h4>
            @if($day->meals->count() > 0)
                @foreach ($day->meals->sortBy('time') as $meal)
                    <div class="meal">
                        <strong>{{ $meal->time ? $meal->time->format('H:i') : 'N/A' }}</strong> 
                        @if($meal->meal_title) - {{ $meal->meal_title }} @endif
                        <br>{{ $meal->description }}
                        @if($meal->remark)<br><em>Note: {{ $meal->remark }}</em>@endif
                    </div>
                @endforeach
            @else
                <p>No meals scheduled for this day.</p>
            @endif
        @empty
            <p>No days found in this diet plan.</p>
        @endforelse
    </div>
</body>
</html>
