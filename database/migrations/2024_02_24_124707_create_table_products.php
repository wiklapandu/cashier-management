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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('author_id');
            $table->bigInteger('price');
            $table->bigInteger('sale_price');
            $table->bigInteger('stock');
            $table->string('status_stock');
            $table->timestamps();
        });

        Schema::create('details_product', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->string('sku')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('thumbnail')->nullable();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
        
        Schema::create('addons_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
        });

        Schema::create('addons_items', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('parent_id');
            $table->string('sku')->nullable();
            $table->bigInteger('stock')->default(0);
            $table->bigInteger('price')->default(0);

            $table->foreign('parent_id')->references('id')->on('addons_products')->onDelete('cascade');
        });

        Schema::create('product_has_addons', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('addons_id');
            $table->bigInteger('price')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('addons_id')->references('id')->on('addons_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('details_product');
        Schema::dropIfExists('addons_products');
        Schema::dropIfExists('addons_items');
        Schema::dropIfExists('product_has_addons');
        Schema::dropIfExists('details_product');
        Schema::dropIfExists('products');
    }
};
