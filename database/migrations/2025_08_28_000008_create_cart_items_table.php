<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_item_id');
            $table->integer('quantity')->nullable();
            $table->dateTime('date')->nullable();

            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('cart_id')->on('carts');

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign(['product_id', 'seller_id', 'category_id'])->references(['product_id', 'seller_id', 'category_id'])->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
