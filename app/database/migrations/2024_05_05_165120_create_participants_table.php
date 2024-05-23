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
        Schema::create('participants', function (Blueprint $table) {
            $table->id      ('par_id');
            $table->string  ('par_nif',9);
            $table->string  ('par_nom',50);
            $table->string  ('par_cognoms',50);
            $table->date    ('par_data_naixement');
            $table->string  ('par_telefon',20);
            $table->string  ('par_email',200);
            $table->boolean ('par_es_federat');
            $table->integer ('par_num_federat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};