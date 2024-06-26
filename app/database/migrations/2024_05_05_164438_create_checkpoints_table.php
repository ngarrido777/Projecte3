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
        Schema::create('checkpoints', function (Blueprint $table) {
            $table->id                  ('chk_id');
            $table->unsignedBigInteger  ('chk_cir_id');
            $table->decimal             ('chk_pk', 10, 2)->nullable();
            /* FK */
            $table->foreign('chk_cir_id')->references('cir_id')->on('circuits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkpoints', function (Blueprint $table) {
            $table->dropConstrainedForeignId('checkpoints_chk_cir_id_foreign');
        });
    }
};
