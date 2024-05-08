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
        Schema::create('registres', function (Blueprint $table) {
            $table->id                  ('reg_id');
            $table->timestamp           ('reg_temps',0);
            $table->unsignedBigInteger  ('reg_ins_id');
            $table->unsignedBigInteger  ('reg_chk_id');
            /* FK */
            $table->foreign('reg_ins_id')->references('ins_id')->on('inscripcions');
            $table->foreign('reg_chk_id')->references('chk_id')->on('checkpoints');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registres', function (Blueprint $table) {
            $table->dropConstrainedForeignId('registres_reg_ins_id_foreign');
            $table->dropConstrainedForeignId('registres_reg_chk_id_foreign');
        });
    }
};