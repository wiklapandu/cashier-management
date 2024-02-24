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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', [
                "pending-payment",
                "processing",
                "on-hold",
                "completed",
                "cancelled"
            ])->default('pending-payment')->nullable();

            $table->timestamp('paid_at')->nullable();
            $table->string('customer_id')->nullable(); /* Getting customer_id form table user */
            
            $table->bigInteger('items_subtotal')->default(0)->nullable();
            $table->bigInteger('order_total')->default(0)->nullable();
            $table->string('author_id')->nullable();  /* Getting customer_id form table user */
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id')->nullable();
            $table->longText('customer_detail')->nullable();
            $table->string('billing_method')->defaul('cash')->nullable();
            $table->longText('billing_detail')->nullable();
            $table->longText('note')->nullable();
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->uuid('product_id');
            $table->string('product_name');
            $table->longText('addons')->nullable();
            $table->bigInteger('qty');
            $table->bigInteger('total');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
    }
};
