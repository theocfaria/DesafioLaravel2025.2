<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name', 45);
            $table->string('email', 45)->unique();
            $table->string('password', 255);
            $table->string('cep', 9);
            $table->integer('number');
            $table->string('street', 60);
            $table->string('district', 45);
            $table->string('city', 45);
            $table->string('state', 45);
            $table->string('extra_info', 45)->nullable();
            $table->string('phone_number', 16);
            $table->date('birth');
            $table->string('cpf', 14)->unique();
            $table->decimal('balance', 10, 2)->nullable();
            $table->binary('image')->nullable();
            $table->unsignedBigInteger('function_id');
            $table->unsignedBigInteger('father_id')->nullable();

            $table->unique(['user_id', 'function_id']);

            $table->foreign('function_id')->references('function_id')->on('functions');
            $table->foreign('father_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};