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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id(); // Regular auto-increment ID as backup
            $table->string('OrderID', 12)->unique(); // CAFFE000001 format
            $table->enum('order_type', ['Dine-in', 'Take-out']);
            $table->dateTime('order_date');
            $table->text('special_request')->nullable();
            $table->integer('total_items');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('totalAmount', 10, 2);
            $table->enum('status', ['New Order', 'Preparing', 'Bumped', 'Done'])->default('New Order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_transactions');
    }
};