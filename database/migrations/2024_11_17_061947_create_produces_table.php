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
        Schema::create('produces', function (Blueprint $table) {
            $table->string("id", 20)->primary();
            $table->string("name", 100);
            $table->integer("calories");
            $table->integer("protein");
            $table->integer("carbohydrates");
            $table->integer("fiber");
            $table->integer("vitamin_a");
            $table->integer("vitamin_b");
            $table->integer("vitamin_c");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produces');
    }
};
