<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kitchen_cooking', function (Blueprint $table) {
            $table->id('KitchenID');
            $table->string('order_name');
            $table->enum('order_type', ['Dine-in', 'Takeaway', 'Delivery'])->default('Dine-in');
            $table->text('special_request')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->timestamps();
            
            $table->index('order_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kitchen_cooking');
    }
};