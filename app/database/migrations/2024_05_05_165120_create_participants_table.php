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
            $table->id          ('par_id');
            $table->string       ('nif',9);
            $table->string       ('nom',50);
            $table->string       ('cognoms',50);
            $table->date         ('data_naixement');
            $table->string       ('telefon',20);
            $table->string       ('email',200);
            $table->boolean      ('es_federat');
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