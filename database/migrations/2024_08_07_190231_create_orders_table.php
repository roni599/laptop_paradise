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
            $table->string('customer_id');
            $table->integer('qty')->nullable();
            $table->float('subtotal')->nullable();
            $table->float('vat')->nullable();
            $table->float('total')->nullable();
            $table->float('pay')->nullable();
            $table->float('due')->nullable();
            $table->string('payby')->nullable();
            $table->string('order_date')->nullable();
            $table->string('order_month')->nullable();
            $table->string('order_year')->nullable();
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
