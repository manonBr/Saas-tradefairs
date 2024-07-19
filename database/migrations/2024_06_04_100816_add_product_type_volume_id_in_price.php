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
        Schema::table('prices', function (Blueprint $table) {
            $table->unsignedBigInteger('productTypeVolume_id')->default(1);
            $table->foreign('productTypeVolume_id')->references('id')->on('product_type_volumes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropForeign(['productTypeVolume_id']);
            $table->dropColumn('productTypeVolume_id');
        });
    }
};
