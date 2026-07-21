<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear test data while preserving users (login details)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Delete in order of dependencies
        DB::table('diet_plan_meals')->delete();
        DB::table('diet_plan_days')->delete();
        DB::table('diet_plans')->delete();
        DB::table('meal_sub_templates')->delete();
        DB::table('meal_templates')->delete();
        DB::table('weight_logs')->delete();
        DB::table('clients')->delete();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
