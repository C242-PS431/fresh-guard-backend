<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scan_results', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('user_id', 20);
            $table->string("produce_id", 20);
            $table->decimal("freshness_score", 3, 2);
            $table->boolean("is_tracked")->default(false);
            $table->timestamp("created_at");

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('produce_id')->on('produces')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_results');
    }
};
