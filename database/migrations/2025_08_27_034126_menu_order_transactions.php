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
        Schema::create('menu_order_transactions', function (Blueprint $table) {
            $table->string('OrderItemID', 12)->primary(); // MENU00000001 format
            $table->string('OrderID', 12); // Foreign key to order_transactions table
            $table->string('ProductName', 255);
            $table->integer('Quantity');
            $table->decimal('unitPrice', 10, 2);
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('OrderID')
                  ->references('OrderID')
                  ->on('order_transactions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_order_transactions');
    }
};