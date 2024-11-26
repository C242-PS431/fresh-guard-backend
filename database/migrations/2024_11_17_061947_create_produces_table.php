<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Date;
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
            $table->string("name", 100)->unique();
            $table->integer("calories")->default(0);
            $table->integer("protein")->default(0);
            $table->integer("carbohydrates")->default(0);
            $table->integer("fiber")->default(0);
            // $table->integer("vitamin_a")->default(0);
            // $table->integer("vitamin_b")->default(0);
            // $table->integer("vitamin_c")->default(0);
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
