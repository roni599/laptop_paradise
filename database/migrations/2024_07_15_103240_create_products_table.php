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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('root')->nullable();
            $table->integer('buying_price')->nullable();
            $table->integer('selling_price');
            $table->date('buying_date')->nullable();  // Change this to date type
            $table->string('image')->nullable();
            $table->integer('product_quantity');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
