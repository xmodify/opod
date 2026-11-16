<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: Hospitals & Agent Configuration Tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->string('name', 255)->nullable();
            $table->string('token_api', 255)->nullable();
            $table->string('agent_url', 255)->nullable()->default('http://127.0.0.1:8989');
            $table->string('contact', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_admin')->default(0);
            $table->string('password', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode'], 'hospitals_hospcode_unique');
        });

        Schema::create('hospital_config', function (Blueprint $table) {
            $table->string('hospcode', 20);
            $table->string('hospname', 100)->nullable();
            $table->integer('bed_qty')->nullable()->default(0);
            $table->integer('bed_use')->nullable()->default(0);
            $table->integer('bed_report')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->primary(['hospcode']);
        });

        Schema::create('agent_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10)->default('ALL');
            $table->string('schedule_type', 20)->default('minute');
            $table->integer('interval_mins')->default(15);
            $table->integer('interval_hours')->default(1);
            $table->integer('start_minute')->nullable()->default(15);
            $table->integer('opd_days_back')->nullable()->default(5);
            $table->integer('ipd_days_back')->nullable()->default(30);
            $table->integer('bed_interval_mins')->nullable()->default(15);
            $table->integer('daily_hour')->default(2);
            $table->integer('daily_minute')->default(0);
            $table->integer('sync_days_back')->default(10);
            $table->boolean('is_active')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->index(['hospcode'], 'idx_hospcode');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('agent_schedules');
        Schema::dropIfExists('hospital_config');
        Schema::dropIfExists('hospitals');
    }
};
