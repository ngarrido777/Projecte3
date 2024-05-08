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
        Schema::create('circuits', function (Blueprint $table) {
            $table->id                  ('cir_id');
            $table->integer             ('cir_num')->nullable();
            $table->unsignedBigInteger  ('cir_cur_id');
            $table->decimal             ('cir_distancia', 10, 2);
            $table->string              ('cir_nom',200);
            $table->decimal             ('cir_preu', 19, 4);
            $table->date                ('cir_temps_estimat')->nullable;
            /* FK y Index */
            $table->index(['cir_cur_id','cir_num']);
            $table->foreign('cir_cur_id')->references('cur_id')->on('curses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuits', function (Blueprint $table) {
            $table->dropConstrainedForeignId('circuits_cir_cur_id_foreign');
        });
    }
};