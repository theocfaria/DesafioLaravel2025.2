<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('seller_id')->after('user_id')->constrained('users');

            $table->string('status')->after('total_value')->default('pending');

            $table->string('pagseguro_transaction_code')->after('status')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropColumn(['seller_id', 'status', 'pagseguro_transaction_code']);
        });
    }
};