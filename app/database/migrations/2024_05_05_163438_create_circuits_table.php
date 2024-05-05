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
            $table->id          ('cir_id');
            $table->int         ('cir_num')->nullable();
            $table->foreignId   ('cir_cur_id')->constrained('curses');
            $table->decimal     ('cir_distancia', 10, 2);
            $tale->string       ('cir_nom',200);
            $table->decimal     ('cir_preu', 19, 4);
            $table->date        ('cir_temps_estimat')->nullable;
            
            $table->index(['cir_cur_id','cir_num']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuits');
    }
};