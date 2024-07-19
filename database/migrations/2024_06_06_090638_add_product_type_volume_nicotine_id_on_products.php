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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('productTypeVolumesNicotines_id')->default(1);
            $table->foreign('productTypeVolumesNicotines_id')->references('id')->on('product_type_volumes_nicotines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['productTypeVolumesNicotines_id']);
            $table->dropColumn('productTypeVolumesNicotines_id');
        });
    }
};
