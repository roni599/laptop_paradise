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
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no');
            $table->string('color');
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0); // 1 for active, 0 for inactive
            $table->tinyInteger('return_status')->default(0); // 0 for not returned, 1 for returned
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade'); // Foreign key relationship with stocks
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key relationship with users
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serials');
    }
};
