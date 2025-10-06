<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kitchen_cooking', function (Blueprint $table) {
            $table->enum('status', ['New Order', 'Preparing', 'Completed'])->default('New Order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('kitchen_cooking', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
