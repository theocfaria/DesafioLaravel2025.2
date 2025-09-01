<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id('purchase_item_id');
            $table->string('product_name', 45);
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');

            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('purchase_id')->references('purchase_id')->on('purchases');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};