<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->string('card_number')->nullable();
            $table->string('expiry_date', 7)->nullable();
            $table->string('cvv', 4)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->dropColumn(['card_number','expiry_date','cvv']);
        });
    }
};
