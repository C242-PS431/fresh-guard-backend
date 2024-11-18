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
        Schema::create('scan_result_tracks', function (Blueprint $table) {
            $table->string('user_id', 20)->index();
            $table->string('scan_result_id', 20)->unique();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('scan_result_id')->on('scan_results')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_result_tracks');
    }
};
