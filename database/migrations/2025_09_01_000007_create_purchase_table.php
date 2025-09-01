<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->dateTime('date');
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('buyer_id');

            $table->foreign(['cart_id', 'buyer_id'])->references(['cart_id', 'buyer_id'])->on('carts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};