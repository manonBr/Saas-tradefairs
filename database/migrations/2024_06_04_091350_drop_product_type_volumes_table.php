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
        Schema::table('product_type_volumes', function (Blueprint $table) {
            Schema::dropIfExists('product_type_volumes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_type_volumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productType_id');
            $table->foreign('productType_id')->references('id')->on('product_type');
            $table->unsignedBigInteger('volumes_id');
            $table->foreign('volumes_id')->references('id')->on('volumes');
            $table->boolean('active');
        });
    }
};