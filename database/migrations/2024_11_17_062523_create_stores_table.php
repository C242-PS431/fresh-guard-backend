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
        Schema::create('stores', function (Blueprint $table) {
            $table->string("id", 20)->primary();
            $table->string("name", 100);
            $table->text("description");
            $table->text("address");
            $table->string("operation_time", 100);
            $table->string("phone", 20);
            $table->decimal("latitude", 12, 10)->nullable();
            $table->decimal("longitude", 13, 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
