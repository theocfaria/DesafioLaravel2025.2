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
            $table->id();
            $table->string('reference_id')->unique();
            $table->foreignId('user_id')->constrained(
                table: 'users', column: 'user_id'
            );
            $table->foreignId('seller_id')->constrained(
                table: 'users', column: 'user_id'
            );
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); 
            $table->string('pagseguro_order_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
