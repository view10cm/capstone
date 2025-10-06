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
        Schema::create('menuCategory', function (Blueprint $table) {
            $table->id('menuCategoryID');
            $table->string('menuCategoryName', 100)->unique();
            $table->timestamps();
        });

        // Insert default categories
        DB::table('menuCategory')->insert([
            [
                'menuCategoryName' => 'Main Course',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menuCategoryName' => 'Drinks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menuCategoryName' => 'Appetizers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menuCategoryName' => 'Others',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menuCategory');
    }
};