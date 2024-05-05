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
        Schema::create('circuits_categories', function (Blueprint $table) {
            $table->id          ('ccc_id');
            $table->foreign     ('ccc_cir_id')->references('cur_id')->on('curses');
            $table->integer     ('ccc_cat_id')->references('cat_id')->on('categories');

            $table->index(['ccc_cir_id','ccc_cat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuits_categories');
    }
};
