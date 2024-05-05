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
            $table->id          ('ins_id');
            $table->foreign     ('ins_par_id')->references('par_id')->on('participants');
            $table->date        ('ins_data');
            $table->integer     ('ins_dorsal');
            $table->tinyInteger ('ins_retirat');
            $table->foreign     ('ins_bea_id')->references('bea_id')->on('beacons');
            $table->foreign     ('ins_ccc_id')->references('ccc_id')->on('circuits_categories');
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