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
        Schema::table('product_user', function (Blueprint $table) {
            // how many of that product
            $table->unsignedInteger('quantity')->default(1);
            // where to deliver
            $table->string('location')->nullable();
            // payment type
            $table->enum('payment_method', ['card','cash','bank_transfer'])
                  ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->dropColumn(['quantity','location','payment_method']);
        });
    }
};


