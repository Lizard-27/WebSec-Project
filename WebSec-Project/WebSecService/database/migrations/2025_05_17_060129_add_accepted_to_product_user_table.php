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
            $table->boolean('accepted')->default(false)->after('delivery_confirmed');
        });
    }

    public function down(): void
    {
        Schema::table('product_user', function (Blueprint $table) {
            $table->dropColumn('accepted');
        });
    }
};
