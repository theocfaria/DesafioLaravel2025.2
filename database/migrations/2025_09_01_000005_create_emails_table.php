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
        Schema::create('emails', function (Blueprint $table) {
            $table->id('email_id');
            $table->string('subject', 45);
            $table->longText('content');
            $table->dateTime('date');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('sender_function_id');

            $table->foreign('receiver_id')->references('user_id')->on('users');
            $table->foreign(['sender_id', 'sender_function_id'])->references(['user_id', 'function_id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};