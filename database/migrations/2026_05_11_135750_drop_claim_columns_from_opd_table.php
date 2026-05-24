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
        Schema::table('opd', function (Blueprint $table) {
            $table->dropColumn([
                'visit_ppfs',
                'visit_ppfs_claim',
                'visit_ucs_cr',
                'visit_ucs_cr_claim',
                'visit_ucs_herb',
                'visit_ucs_herb_claim',
                'visit_ucs_healthmed',
                'inc_ppfs',
                'inc_ppfs_claim',
                'inc_ppfs_receive',
                'inc_uccr',
                'inc_uccr_claim',
                'inc_uccr_receive',
                'inc_herb',
                'inc_herb_claim',
                'inc_herb_receive'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opd', function (Blueprint $table) {
            // Visits
            $table->integer('visit_ppfs')->default(0);
            $table->integer('visit_ppfs_claim')->default(0);
            $table->integer('visit_ucs_cr')->default(0);
            $table->integer('visit_ucs_cr_claim')->default(0);
            $table->integer('visit_ucs_herb')->default(0);
            $table->integer('visit_ucs_herb_claim')->default(0);
            $table->integer('visit_ucs_healthmed')->default(0);
            
            // Incomes
            $table->double('inc_ppfs', 15, 2)->default(0);
            $table->double('inc_ppfs_claim', 15, 2)->default(0);
            $table->double('inc_ppfs_receive', 15, 2)->default(0);
            $table->double('inc_uccr', 15, 2)->default(0);
            $table->double('inc_uccr_claim', 15, 2)->default(0);
            $table->double('inc_uccr_receive', 15, 2)->default(0);
            $table->double('inc_herb', 15, 2)->default(0);
            $table->double('inc_herb_claim', 15, 2)->default(0);
            $table->double('inc_herb_receive', 15, 2)->default(0);
        });
    }
};
