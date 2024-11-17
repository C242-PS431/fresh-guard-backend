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
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('store_id', 20);
            $table->string('product_category_id', 20);
            $table->string('name', 100);
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
            $table->softDeletes();

            

            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
