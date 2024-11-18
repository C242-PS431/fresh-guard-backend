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
        Schema::create('favorite_stores', function (Blueprint $table) {
            $table->string('user_id', 20);
            $table->string('store_id', 20);

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('store_id')->on('stores')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_stores');
    }
};
