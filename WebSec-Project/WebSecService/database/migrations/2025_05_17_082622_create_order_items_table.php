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
        Schema::create('order_items', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('order_id');
                $t->unsignedBigInteger('product_id');
                $t->integer('quantity');
                $t->decimal('price',10,2);
                $t->timestamps();

                $t->foreign('order_id')->references('id')->on('orders')
                ->onDelete('cascade');
                $t->foreign('product_id')->references('id')->on('products');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
