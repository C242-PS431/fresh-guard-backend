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
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string("produce_type_id", 20);
            $table->decimal("freshness_score", 3, 2);
            $table->decimal("rotten_score", 3, 2);
            $table->timestamp("scanned_at");
            $table->boolean("consumable")->default(false);
            $table->integer("should_consumed_id")->default(0);
            $table->text("notes")->nullable();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('produce_type_id')->on('produce_types')->references('id');
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
