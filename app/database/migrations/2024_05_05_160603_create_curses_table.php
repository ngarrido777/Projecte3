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
        Schema::create('curses', function (Blueprint $table) {
            $table->id          ('cur_id');
            $table->string      ('cur_nom', 20);
            $table->date        ('cur_data_inici');
            $table->date        ('cur_data_fi');
            $table->string      ('cur_lloc', 20);
            $table->unsignedBigInteger     ('cur_esp_id');
            $table->unsignedBigInteger     ('cur_est_id');
            $table->string      ('cur_desc', 1000)->nullable();
            $table->integer     ('cur_limit_inscr');
            $table->binary      ('cur_foto');
            $table->string      ('cur_web', 20)->nullable();
            /* COMO MIERDAS SE HACEN LAS FORANEAS */
            $table->index       ('cur_esp_id');
            $table->foreign     ('cur_esp_id')->references('esp_id')->on('esports');
            $table->index       ('cur_est_id');
            $table->foreign     ('cur_est_id')->references('est_id')->on('estats_cursa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curses');
    }
};
