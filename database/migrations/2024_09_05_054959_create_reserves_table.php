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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->nullable()->default(0);
            $table->integer('amount');
            $table->string('status')->nullable()->default(0);
            $table->unsignedBigInteger('investment_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('payment_type_id')->references('id')->on('paymenttypes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
