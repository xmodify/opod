<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: Lookup & Master Reference Tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lookup_icd10', function (Blueprint $table) {
            $table->string('icd10', 100);
            $table->string('pp', 1)->nullable();
            $table->primary(['icd10']);
        });

        Schema::create('ipd_bed_type', function (Blueprint $table) {
            $table->string('bed_code', 6);
            $table->string('bed_name', 100);
            $table->string('unit', 100);
            $table->primary(['bed_code']);
        });

        Schema::create('opoh_doctors', function (Blueprint $table) {
            $table->id();
            $table->string('pname', 50)->nullable();
            $table->string('fname', 100);
            $table->string('lname', 100);
            $table->string('doctor_name', 150);
            $table->string('cid', 13)->nullable();
            $table->string('licenseno', 20)->nullable();
            $table->string('spclty_code', 10);
            $table->string('specialty_name', 100);
            $table->string('position', 150)->nullable();
            $table->string('origin_hospcode', 10)->nullable();
            $table->enum('is_active', ['y','n'])->default('Y');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->index(['cid', 'licenseno', 'is_active'], 'idx_doctor_lookup');
            $table->index(['origin_hospcode'], 'idx_doctor_origin');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('opoh_doctors');
        Schema::dropIfExists('ipd_bed_type');
        Schema::dropIfExists('lookup_icd10');
    }
};
