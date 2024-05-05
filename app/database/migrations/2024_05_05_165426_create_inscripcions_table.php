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
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id('ins_id');
            $table->intforeignId('ins_par_id')->constraint('participants');
            $table->date('ins_data');
            $table->int('ins_dorsal');
            $table->tinyInteger('ins_retirat');
            $table->foreignId('ins_bea_id')->nullable()->constrained('beacons');
            $table->foreignId('ins_ccc_id')->nullable()->constrained('circuits_categories');
            
            $table->foreignId   ('chk_cir_id')->constrained('circuits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};