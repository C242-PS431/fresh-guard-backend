<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('scan_results', function(Blueprint $table){
            $table->string('smell', 20);
            $table->string('texture', 20);
            $table->boolean('verified_store')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('scan_results', ['texture', 'smell', 'verified_store']);
    }
};
