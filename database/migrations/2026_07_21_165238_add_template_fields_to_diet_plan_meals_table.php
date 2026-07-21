<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diet_plan_meals', function (Blueprint $table) {
            $table->foreignId('meal_template_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('meal_sub_template_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diet_plan_meals', function (Blueprint $table) {
            $table->dropForeign(['meal_sub_template_id']);
            $table->dropForeign(['meal_template_id']);
            $table->dropColumn(['meal_sub_template_id', 'meal_template_id']);
        });
    }
};
