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
        Schema::create('orders', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('user_id');
                $t->string('location');
                $t->decimal('lat',10,7)->nullable();
                $t->decimal('lng',10,7)->nullable();
                $t->string('payment_method');
                $t->decimal('total',10,2);
                $t->boolean('accepted')->default(false);
                $t->boolean('delivery_confirmed')->default(false);
                $t->timestamps();

                $t->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
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
