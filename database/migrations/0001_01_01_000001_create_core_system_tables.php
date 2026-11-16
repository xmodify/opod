<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: Core System & Authentication Tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10)->nullable();
            $table->string('name', 255);
            $table->string('position', 255)->nullable();
            $table->string('cid', 13)->nullable();
            $table->string('email', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('provider_id', 50)->nullable();
            $table->text('moph_token')->nullable();
            $table->timestamp('moph_token_expire')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('role', 255)->default('user');
            $table->boolean('allow_death')->default(0);
            $table->boolean('allow_birth')->default(0);
            $table->boolean('allow_death_dashboard')->default(0);
            $table->boolean('allow_birth_dashboard')->default(0);
            $table->boolean('allow_aemr')->default(0);
            $table->boolean('allow_opoh')->default(0);
            $table->char('active', 1)->default('Y');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['email'], 'users_email_unique');
            $table->index(['cid'], 'users_cid_index');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email', 191);
            $table->string('token', 191);
            $table->timestamp('created_at')->nullable();
            $table->primary(['email']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 191);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');
            $table->primary(['id']);
            $table->index(['user_id'], 'sessions_user_id_index');
            $table->index(['last_activity'], 'sessions_last_activity_index');
        });

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('tokenable_type', 191);
            $table->unsignedBigInteger('tokenable_id');
            $table->text('name');
            $table->string('token', 64);
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['token'], 'personal_access_tokens_token_unique');
            $table->index(['tokenable_type', 'tokenable_id'], 'pat_tokenable_type_id_index');
            $table->index(['expires_at'], 'personal_access_tokens_expires_at_index');
        });

        Schema::create('main_setting', function (Blueprint $table) {
            $table->string('name', 100);
            $table->text('value')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['name']);
        });

        Schema::create('budget_year', function (Blueprint $table) {
            $table->string('LEAVE_YEAR_ID', 10)->default('');
            $table->string('LEAVE_YEAR_NAME', 255)->nullable()->default('');
            $table->date('DATE_BEGIN')->nullable();
            $table->date('DATE_END')->nullable();
            $table->enum('ACTIVE', ['true','false'])->nullable()->default('False');
            $table->integer('DAY_PER_YEAR')->nullable()->default(10);
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->primary(['LEAVE_YEAR_ID']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('budget_year');
        Schema::dropIfExists('main_setting');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
