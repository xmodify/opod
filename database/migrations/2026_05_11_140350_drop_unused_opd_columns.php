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
                'visit_endpoint',
                'visit_moph_oapp_booking',
                'visit_moph_oapp'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opd', function (Blueprint $table) {
            $table->integer('visit_endpoint')->default(0);
            $table->integer('visit_moph_oapp_booking')->default(0);
            $table->integer('visit_moph_oapp')->default(0);
        });
    }
};
