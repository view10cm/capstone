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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id('ingredient_id'); // Primary key with auto increment
            $table->string('ingredient_name', 255); // VARCHAR(255)
            $table->string('ingredient_category', 100); // VARCHAR(100)
            $table->integer('ingredient_quantity')->default(0); // INT with default 0
            $table->string('ingredient_availability', 50)->default('Available'); // VARCHAR(50)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};