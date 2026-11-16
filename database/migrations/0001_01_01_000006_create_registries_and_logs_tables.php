<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: Registries (Births, Deaths) & Audit Logs Tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('births', function (Blueprint $table) {
            $table->id();
            $table->string('prov', 10)->nullable();
            $table->string('amp', 10)->nullable();
            $table->string('tb', 10)->nullable();
            $table->string('sex', 2)->nullable();
            $table->integer('byear')->nullable();
            $table->integer('bmon')->nullable();
            $table->integer('bdate')->nullable();
            $table->string('nat', 10)->nullable();
            $table->integer('no')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('mage')->nullable();
            $table->string('ket', 10)->nullable();
            $table->integer('yptell')->nullable();
            $table->integer('mptell')->nullable();
            $table->integer('dptell')->nullable();
            $table->text('maddr')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->index(['byear'], 'births_byear_index');
        });

        Schema::create('deaths', function (Blueprint $table) {
            $table->id();
            $table->string('pid', 13);
            $table->string('sex', 2)->nullable();
            $table->integer('age')->nullable();
            $table->integer('ddate')->nullable();
            $table->integer('dmon')->nullable();
            $table->integer('dyear')->nullable();
            $table->string('drcode', 10)->nullable();
            $table->string('hos_id', 10)->nullable();
            $table->string('lccaattmm', 15)->nullable();
            $table->string('ncause', 10)->nullable();
            $table->integer('bdate')->nullable();
            $table->integer('bmon')->nullable();
            $table->integer('byear')->nullable();
            $table->string('dplace', 50)->nullable();
            $table->string('ghos', 10)->nullable();
            $table->string('codepro', 10)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->index(['pid'], 'deaths_pid_index');
            $table->index(['dyear'], 'deaths_dyear_index');
        });

        Schema::create('aemr_access_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('username', 100)->nullable();
            $table->string('user_name', 255);
            $table->string('user_role', 50)->default('staff');
            $table->string('user_hospcode', 10)->nullable();
            $table->string('provider_id', 100)->nullable();
            $table->string('action', 50)->default('SEARCH_CID');
            $table->string('target_cid', 13)->nullable();
            $table->string('target_hn', 50)->nullable();
            $table->string('target_vn', 50)->nullable();
            $table->string('target_hospcode', 10)->nullable();
            $table->string('reason', 255)->default('การตรวจรักษาทั่วไป');
            $table->string('ip_address', 45)->default('127.0.0.1');
            $table->text('user_agent')->nullable();
            $table->string('request_url', 500)->nullable();
            $table->string('http_method', 10)->default('POST');
            $table->string('status', 20)->default('SUCCESS');
            $table->integer('http_status_code')->default(200);
            $table->integer('response_time_ms')->nullable()->default(0);
            $table->integer('record_count')->nullable()->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['target_cid'], 'idx_target_cid');
            $table->index(['user_id'], 'idx_user_id');
            $table->index(['action'], 'idx_action');
            $table->index(['created_at'], 'idx_created_at');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('aemr_access_logs');
        Schema::dropIfExists('deaths');
        Schema::dropIfExists('births');
    }
};
