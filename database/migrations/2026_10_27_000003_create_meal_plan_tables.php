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
        if (!Schema::hasTable('user_meal_plans')) {
            Schema::create('user_meal_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('goal')->nullable();
                $table->unsignedTinyInteger('total_weeks')->default(4);
                $table->unsignedTinyInteger('current_week')->default(1);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('status')->default('active'); // active, paused, completed, cancelled
                $table->text('admin_notes')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'status']);
            });
        }

        if (!Schema::hasTable('user_weekly_plans')) {
            Schema::create('user_weekly_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_meal_plan_id')->constrained()->cascadeOnDelete();
                $table->unsignedTinyInteger('week_number');
                $table->string('title')->nullable();
                $table->text('goals')->nullable();
                $table->longText('content')->nullable(); // Meal plan / instructions for the week
                $table->string('attachment_path')->nullable(); // Optional PDF/image
                $table->boolean('is_completed')->default(false);
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->unique(['user_meal_plan_id', 'week_number']);
            });
        }

        if (!Schema::hasTable('user_daily_health_trackings')) {
            Schema::create('user_daily_health_trackings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_meal_plan_id')->nullable()->constrained()->nullOnDelete();
                $table->date('tracking_date');
                $table->decimal('water_intake_liters', 4, 2)->nullable();
                $table->unsignedTinyInteger('water_intake_glasses')->nullable();
                $table->decimal('sleep_hours', 4, 1)->nullable();
                $table->boolean('walked_today')->default(false);
                $table->unsignedInteger('steps_count')->nullable();
                $table->boolean('exercised_today')->default(false);
                $table->boolean('did_cardio')->default(false);
                $table->unsignedSmallInteger('cardio_minutes')->nullable();
                $table->boolean('lifted_weights')->default(false);
                $table->unsignedSmallInteger('weightlifting_minutes')->nullable();
                $table->text('exercise_notes')->nullable();
                $table->boolean('ate_breakfast')->default(false);
                $table->boolean('ate_lunch')->default(false);
                $table->boolean('ate_dinner')->default(false);
                $table->text('meal_notes')->nullable();
                $table->unsignedTinyInteger('mood_rating')->nullable();
                $table->unsignedTinyInteger('energy_rating')->nullable();
                $table->unsignedTinyInteger('daily_score')->default(0);
                $table->timestamps();

                $table->unique(['user_id', 'tracking_date']);
            });
        }

        if (!Schema::hasTable('user_daily_meal_logs')) {
            Schema::create('user_daily_meal_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_meal_plan_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('user_weekly_plan_id')->nullable()->constrained()->nullOnDelete();
                $table->date('log_date');
                $table->string('meal_type'); // breakfast, lunch, dinner, snack
                $table->text('food_items')->nullable();
                $table->text('description')->nullable();
                $table->text('notes')->nullable();
                $table->string('photo_path')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'log_date', 'meal_type']);
            });
        }

        if (!Schema::hasTable('user_weekly_assessments')) {
            Schema::create('user_weekly_assessments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_meal_plan_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_weekly_plan_id')->nullable()->constrained()->nullOnDelete();
                $table->unsignedTinyInteger('week_number');
                $table->decimal('weight_kg', 5, 2)->nullable();
                $table->decimal('body_fat_percentage', 4, 1)->nullable();
                $table->decimal('chest_cm', 5, 1)->nullable();
                $table->decimal('waist_cm', 5, 1)->nullable();
                $table->decimal('hips_cm', 5, 1)->nullable();
                $table->text('what_went_well')->nullable();
                $table->text('challenges_faced')->nullable();
                $table->text('next_week_goals')->nullable();
                $table->string('front_photo')->nullable();
                $table->string('side_photo')->nullable();
                $table->string('back_photo')->nullable();
                $table->boolean('is_completed')->default(false);
                $table->text('admin_feedback')->nullable();
                $table->timestamp('feedback_at')->nullable();
                $table->timestamps();

                $table->unique(['user_meal_plan_id', 'week_number']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_weekly_assessments');
        Schema::dropIfExists('user_daily_meal_logs');
        Schema::dropIfExists('user_daily_health_trackings');
        Schema::dropIfExists('user_weekly_plans');
        Schema::dropIfExists('user_meal_plans');
    }
};
