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
            $table->id          ('chk_id');
            $table->foreignId   ('chk_cir_id')->constrained('circuits');
            $table->decimal     ('chk_pk', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkpoints');
    }
};
