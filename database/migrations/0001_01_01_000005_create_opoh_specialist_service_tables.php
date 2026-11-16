<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: OPOH Specialist Services Ingest Tables
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opoh_opd_service', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('vstdate');
            $table->string('spclty_code', 10);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('licenseno', 20)->nullable();
            $table->string('specialty_name', 100);
            $table->unsignedInteger('hn_total')->default(0);
            $table->unsignedInteger('visit_total')->default(0);
            $table->unsignedInteger('visit_ucs')->default(0);
            $table->unsignedInteger('visit_ofc')->default(0);
            $table->unsignedInteger('visit_lgo')->default(0);
            $table->unsignedInteger('visit_sss')->default(0);
            $table->unsignedInteger('visit_other')->default(0);
            $table->unsignedInteger('visit_telemed')->default(0);
            $table->unsignedInteger('refer_to_origin')->default(0);
            $table->unsignedInteger('admit_ipd')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('visit_ucs_incup')->default(0);
            $table->unsignedInteger('visit_ucs_outprov')->default(0);
            $table->unique(['hospcode', 'vstdate', 'spclty_code', 'doctor_id'], 'uk_opoh_opd');
            $table->index(['vstdate'], 'idx_vstdate');
            $table->index(['hospcode'], 'idx_hospcode');
            $table->index(['doctor_id', 'licenseno'], 'idx_doctor');
        });

        Schema::create('opoh_opd_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('vstdate');
            $table->string('spclty_code', 10);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('icd10', 10);
            $table->string('diag_name', 255);
            $table->unsignedInteger('case_total')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode', 'vstdate', 'spclty_code', 'doctor_id', 'icd10'], 'uk_opoh_opd_diag');
            $table->index(['vstdate'], 'idx_opd_diag_vstdate');
            $table->index(['hospcode'], 'idx_opd_diag_hospcode');
            $table->index(['icd10'], 'idx_opd_diag_icd10');
        });

        Schema::create('opoh_ipd_service', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('dchdate');
            $table->string('spclty_code', 10);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('licenseno', 20)->nullable();
            $table->string('specialty_name', 100);
            $table->unsignedInteger('an_total')->default(0);
            $table->unsignedInteger('admdate_total')->default(0);
            $table->decimal('adjrw_total', 10, 4)->default(0.0000);
            $table->unsignedInteger('operation_total')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedInteger('an_ucs_incup')->default(0);
            $table->unsignedInteger('an_ucs_outprov')->default(0);
            $table->unsignedInteger('an_ofc')->default(0);
            $table->unsignedInteger('an_lgo')->default(0);
            $table->unsignedInteger('an_sss')->default(0);
            $table->unsignedInteger('an_other')->default(0);
            $table->unsignedInteger('admdate_ucs_incup')->default(0);
            $table->unsignedInteger('admdate_ucs_outprov')->default(0);
            $table->unsignedInteger('admdate_ofc')->default(0);
            $table->unsignedInteger('admdate_lgo')->default(0);
            $table->unsignedInteger('admdate_sss')->default(0);
            $table->unsignedInteger('admdate_other')->default(0);
            $table->decimal('adjrw_ucs_incup', 10, 4)->default(0.0000);
            $table->decimal('adjrw_ucs_outprov', 10, 4)->default(0.0000);
            $table->decimal('adjrw_ofc', 10, 4)->default(0.0000);
            $table->decimal('adjrw_lgo', 10, 4)->default(0.0000);
            $table->decimal('adjrw_sss', 10, 4)->default(0.0000);
            $table->decimal('adjrw_other', 10, 4)->default(0.0000);
            $table->unique(['hospcode', 'dchdate', 'spclty_code', 'doctor_id'], 'uk_opoh_ipd');
            $table->index(['doctor_id'], 'idx_ipd_doctor');
        });

        Schema::create('opoh_ipd_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('dchdate');
            $table->string('spclty_code', 10);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('icd10', 10);
            $table->string('diag_name', 255);
            $table->unsignedInteger('case_total')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode', 'dchdate', 'spclty_code', 'doctor_id', 'icd10'], 'uk_opoh_ipd_diag');
            $table->index(['dchdate'], 'idx_ipd_diag_dchdate');
            $table->index(['hospcode'], 'idx_ipd_diag_hospcode');
            $table->index(['icd10'], 'idx_ipd_diag_icd10');
        });

        Schema::create('opoh_ipd_hospital_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('dchdate');
            $table->unsignedInteger('an_total')->default(0);
            $table->unsignedInteger('admdate_total')->default(0);
            $table->decimal('adjrw_total', 10, 4)->default(0.0000);
            $table->unsignedInteger('operation_total')->default(0);
            $table->unsignedInteger('an_ucs_incup')->default(0);
            $table->unsignedInteger('an_ucs_outprov')->default(0);
            $table->unsignedInteger('an_ofc')->default(0);
            $table->unsignedInteger('an_lgo')->default(0);
            $table->unsignedInteger('an_sss')->default(0);
            $table->unsignedInteger('an_other')->default(0);
            $table->unsignedInteger('admdate_ucs_incup')->default(0);
            $table->unsignedInteger('admdate_ucs_outprov')->default(0);
            $table->unsignedInteger('admdate_ofc')->default(0);
            $table->unsignedInteger('admdate_lgo')->default(0);
            $table->unsignedInteger('admdate_sss')->default(0);
            $table->unsignedInteger('admdate_other')->default(0);
            $table->decimal('adjrw_ucs_incup', 10, 4)->default(0.0000);
            $table->decimal('adjrw_ucs_outprov', 10, 4)->default(0.0000);
            $table->decimal('adjrw_ofc', 10, 4)->default(0.0000);
            $table->decimal('adjrw_lgo', 10, 4)->default(0.0000);
            $table->decimal('adjrw_sss', 10, 4)->default(0.0000);
            $table->decimal('adjrw_other', 10, 4)->default(0.0000);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode', 'dchdate'], 'uk_opoh_ipd_hosp_sum');
            $table->index(['dchdate'], 'idx_opoh_ipd_hosp_sum_dchdate');
        });

        Schema::create('opoh_income_categories', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->string('service_type', 10)->default('OPD');
            $table->date('vstdate');
            $table->string('spclty_code', 10);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('licenseno', 20)->nullable();
            $table->integer('drg_chrgitem_id');
            $table->string('drg_chrgitem_name', 150);
            $table->decimal('inc_ucs_incup', 12, 2)->default(0.00);
            $table->decimal('inc_ucs_outprov', 12, 2)->default(0.00);
            $table->decimal('inc_ofc', 12, 2)->default(0.00);
            $table->decimal('inc_lgo', 12, 2)->default(0.00);
            $table->decimal('inc_sss', 12, 2)->default(0.00);
            $table->decimal('inc_other', 12, 2)->default(0.00);
            $table->decimal('inc_total', 12, 2)->default(0.00);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode', 'service_type', 'vstdate', 'doctor_id', 'drg_chrgitem_id'], 'uk_opoh_inc_cat');
            $table->index(['vstdate'], 'idx_vstdate');
            $table->index(['hospcode'], 'idx_hospcode');
            $table->index(['doctor_id'], 'idx_doctor');
            $table->index(['spclty_code'], 'idx_spclty');
        });

        Schema::create('opoh_ipd_income_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('dchdate');
            $table->integer('drg_chrgitem_id');
            $table->string('drg_chrgitem_name', 150);
            $table->decimal('inc_ucs_incup', 12, 2)->default(0.00);
            $table->decimal('inc_ucs_outprov', 12, 2)->default(0.00);
            $table->decimal('inc_ofc', 12, 2)->default(0.00);
            $table->decimal('inc_lgo', 12, 2)->default(0.00);
            $table->decimal('inc_sss', 12, 2)->default(0.00);
            $table->decimal('inc_other', 12, 2)->default(0.00);
            $table->decimal('inc_total', 12, 2)->default(0.00);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unique(['hospcode', 'dchdate', 'drg_chrgitem_id'], 'uk_opoh_ipd_inc_sum');
            $table->index(['dchdate'], 'idx_opoh_ipd_inc_sum_dchdate');
        });

        Schema::create('opoh_operation_service', function (Blueprint $table) {
            $table->id();
            $table->string('hospcode', 10);
            $table->date('operation_date');
            $table->string('spclty_code', 10);
            $table->string('specialty_name', 100);
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->string('licenseno', 20)->nullable();
            $table->string('icd9', 10)->nullable();
            $table->string('operation_name', 255);
            $table->string('op_type', 10)->default('IPD');
            $table->unsignedInteger('case_total')->default(1);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->decimal('adjrw_total', 10, 4)->default(0.0000);
            $table->unsignedInteger('case_ucs_incup')->default(0);
            $table->unsignedInteger('case_ucs_outprov')->default(0);
            $table->unsignedInteger('case_ofc')->default(0);
            $table->unsignedInteger('case_lgo')->default(0);
            $table->unsignedInteger('case_sss')->default(0);
            $table->unsignedInteger('case_other')->default(0);
            $table->unique(['hospcode', 'operation_date', 'spclty_code', 'doctor_id', 'icd9', 'op_type'], 'uk_opoh_op');
            $table->index(['operation_date'], 'idx_op_date');
            $table->index(['hospcode'], 'idx_op_hospcode');
            $table->index(['spclty_code'], 'idx_op_spclty');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('opoh_operation_service');
        Schema::dropIfExists('opoh_ipd_income_summaries');
        Schema::dropIfExists('opoh_income_categories');
        Schema::dropIfExists('opoh_ipd_hospital_summaries');
        Schema::dropIfExists('opoh_ipd_diagnoses');
        Schema::dropIfExists('opoh_ipd_service');
        Schema::dropIfExists('opoh_opd_diagnoses');
        Schema::dropIfExists('opoh_opd_service');
    }
};
