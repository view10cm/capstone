<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kitchen_cooking_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchen_cooking_id')->constrained('kitchen_cooking', 'KitchenID')->onDelete('cascade');
            $table->string('product_name');
            $table->string('size')->nullable(); // e.g., "8oz"
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->timestamps();
            
            $table->index('kitchen_cooking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitchen_cooking_products');
    }
};