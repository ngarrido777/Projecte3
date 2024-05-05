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
        Schema::create('categories', function (Blueprint $table) {
            $table->id          ('cat_id');
            $table->unsignedBigInteger     ('cat_esp_id');
            $table->string      ('cat_nom',20);
            /* FK */
            $table->foreign     ('cat_esp_id')->references('esp_id')->on('esports');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};