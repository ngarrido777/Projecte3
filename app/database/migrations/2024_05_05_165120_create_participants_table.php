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
            $tale->string       ('nif',9);
            $tale->string       ('nom',50);
            $tale->string       ('cognoms',50);
            $tale->date         ('data_naixement');
            $tale->string       ('telefon',20);
            $tale->string       ('email',200);
            $tale->tinyInteger  ('es_federat',1);
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