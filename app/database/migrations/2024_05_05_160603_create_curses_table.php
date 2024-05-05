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
            $table->foreignId   ('cur_esp_id')->constrained('esports');
            $table->foreignId   ('cur_est_id')->constrained('estats_cursa');
            $table->string      ('cur_desc', 1000)->nullable();
            $table->integer     ('cur_limit_inscr');
            $table->binary      ('cur_foto');
            $table->string      ('cur_web', 20)->nullable();
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
