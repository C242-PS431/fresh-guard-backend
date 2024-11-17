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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string("user_id", 20)->unique();
            $table->string("full_name", 100);
            $table->date("birth_date")->nullable();
            $table->string("gender", 20)->nullable();
            $table->string("profile_picture", 200)->nullable();
            $table->text("address")->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
