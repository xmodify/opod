<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration Group: Core Hospital Services Ingest Tables (OPD, IPD, Refer, Operation, Bed)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opd', function (Blueprint $table) {
            $table->string('hospcode', 10);
            $table->date('vstdate');
            $table->unsignedInteger('hn_total')->default(0);
            $table->unsignedInteger('visit_total')->default(0);
            $table->unsignedInteger('visit_total_op')->default(0);
            $table->unsignedInteger('visit_total_pp')->default(0);
            $table->integer('visit_endpoint')->default(0);
            $table->unsignedInteger('visit_ucs_incup')->default(0);
            $table->unsignedInteger('visit_ucs_inprov')->default(0);
            $table->unsignedInteger('visit_ucs_outprov')->default(0);
            $table->unsignedInteger('visit_ofc')->default(0);
            $table->unsignedInteger('visit_bkk')->default(0);
            $table->unsignedInteger('visit_bmt')->default(0);
            $table->unsignedInteger('visit_sss')->default(0);
            $table->unsignedInteger('visit_lgo')->default(0);
            $table->unsignedInteger('visit_fss')->default(0);
            $table->unsignedInteger('visit_stp')->default(0);
            $table->unsignedInteger('visit_pay')->default(0);
            $table->integer('visit_ucs_healthmed')->default(0);
            $table->integer('visit_healthmed')->default(0);
            $table->integer('visit_dent')->default(0);
            $table->integer('visit_physic')->default(0);
            $table->integer('visit_anc')->nullable()->default(0);
            $table->integer('visit_telehealth')->nullable()->default(0);
            $table->integer('visit_moph_oapp_booking')->nullable()->default(0);
            $table->integer('visit_moph_oapp')->nullable()->default(0);
            $table->double('inc_total', 15, 2)->default(0.00);
            $table->double('inc_lab_total', 15, 2)->default(0.00);
            $table->double('inc_drug_total', 15, 2)->default(0.00);
            $table->double('inc_ucs_incup', 15, 2)->default(0.00);
            $table->double('inc_lab_ucs_incup', 15, 2)->default(0.00);
            $table->double('inc_drug_ucs_incup', 15, 2)->default(0.00);
            $table->double('inc_ucs_inprov', 15, 2)->default(0.00);
            $table->double('inc_lab_ucs_inprov', 15, 2)->default(0.00);
            $table->double('inc_drug_ucs_inprov', 15, 2)->default(0.00);
            $table->double('inc_ucs_outprov', 15, 2)->default(0.00);
            $table->double('inc_lab_ucs_outprov', 15, 2)->default(0.00);
            $table->double('inc_drug_ucs_outprov', 15, 2)->default(0.00);
            $table->double('inc_ofc', 15, 2)->default(0.00);
            $table->double('inc_lab_ofc', 15, 2)->default(0.00);
            $table->double('inc_drug_ofc', 15, 2)->default(0.00);
            $table->double('inc_bkk', 15, 2)->default(0.00);
            $table->double('inc_lab_bkk', 15, 2)->default(0.00);
            $table->double('inc_drug_bkk', 15, 2)->default(0.00);
            $table->double('inc_bmt', 15, 2)->default(0.00);
            $table->double('inc_lab_bmt', 15, 2)->default(0.00);
            $table->double('inc_drug_bmt', 15, 2)->default(0.00);
            $table->double('inc_sss', 15, 2)->default(0.00);
            $table->double('inc_lab_sss', 15, 2)->default(0.00);
            $table->double('inc_drug_sss', 15, 2)->default(0.00);
            $table->double('inc_lgo', 15, 2)->default(0.00);
            $table->double('inc_lab_lgo', 15, 2)->default(0.00);
            $table->double('inc_drug_lgo', 15, 2)->default(0.00);
            $table->double('inc_fss', 15, 2)->default(0.00);
            $table->double('inc_lab_fss', 15, 2)->default(0.00);
            $table->double('inc_drug_fss', 15, 2)->default(0.00);
            $table->double('inc_stp', 15, 2)->default(0.00);
            $table->double('inc_lab_stp', 15, 2)->default(0.00);
            $table->double('inc_drug_stp', 15, 2)->default(0.00);
            $table->double('inc_pay', 15, 2)->default(0.00);
            $table->double('inc_lab_pay', 15, 2)->default(0.00);
            $table->double('inc_drug_pay', 15, 2)->default(0.00);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['hospcode', 'vstdate']);
            $table->index(['vstdate'], 'opd_vstdate_index');
        });

        Schema::create('ipd', function (Blueprint $table) {
            $table->string('hospcode', 10);
            $table->date('dchdate');
            $table->integer('an_total');
            $table->unsignedInteger('admdate')->default(0);
            $table->unsignedDouble('bed_occupancy', 10, 2)->default(0.00);
            $table->unsignedDouble('active_bed', 10, 2)->default(0.00);
            $table->unsignedDouble('cmi', 10, 2)->default(0.00);
            $table->double('adjrw', 10, 5);
            $table->double('inc_total', 15, 2);
            $table->double('inc_lab_total', 15, 2);
            $table->double('inc_drug_total', 15, 2);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['hospcode', 'dchdate']);
            $table->index(['dchdate'], 'ipd_dchdate_index');
        });

        Schema::create('refer', function (Blueprint $table) {
            $table->string('hospcode', 10);
            $table->date('vstdate');
            $table->unsignedInteger('visit_referout_inprov')->default(0);
            $table->unsignedInteger('visit_referout_outprov')->default(0);
            $table->unsignedInteger('visit_referout_inprov_ipd')->default(0);
            $table->unsignedInteger('visit_referout_outprov_ipd')->default(0);
            $table->unsignedInteger('visit_referin_inprov')->default(0);
            $table->unsignedInteger('visit_referin_outprov')->default(0);
            $table->unsignedInteger('visit_referin_inprov_ipd')->default(0);
            $table->unsignedInteger('visit_referin_outprov_ipd')->default(0);
            $table->unsignedInteger('visit_referback_inprov')->default(0);
            $table->unsignedInteger('visit_referback_outprov')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['hospcode', 'vstdate']);
            $table->index(['vstdate'], 'refer_vstdate_index');
        });

        Schema::create('operation', function (Blueprint $table) {
            $table->string('hospcode', 10);
            $table->date('vstdate');
            $table->unsignedInteger('visit_operation')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->primary(['hospcode', 'vstdate']);
            $table->index(['vstdate'], 'operation_vstdate_index');
        });

        Schema::create('ipd_bed_dep', function (Blueprint $table) {
            $table->string('hospcode', 9);
            $table->string('bed_code', 6);
            $table->integer('bed_qty')->nullable();
            $table->integer('bed_use')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->primary(['hospcode', 'bed_code']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('ipd_bed_dep');
        Schema::dropIfExists('operation');
        Schema::dropIfExists('refer');
        Schema::dropIfExists('ipd');
        Schema::dropIfExists('opd');
    }
};
