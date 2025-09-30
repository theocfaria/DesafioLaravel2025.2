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
            $table->timestamp('email_verified_at')->nullable();
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
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('function_id');
            $table->unsignedBigInteger('father_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->unique(['user_id', 'function_id']);

            $table->foreign('function_id')->references('function_id')->on('functions');
            $table->foreign('father_id')->references('user_id')->on('users');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};