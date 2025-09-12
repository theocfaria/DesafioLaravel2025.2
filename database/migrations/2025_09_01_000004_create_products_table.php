<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->string('name', 45);
            $table->binary('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->longText('description');
            $table->timestamps();

            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('category_id');

            $table->primary(['product_id', 'seller_id', 'category_id']);

            $table->foreign('seller_id')->references('user_id')->on('users');
            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
