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
        Schema::create('product_type_volumes_nicotines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productType_id');
            $table->foreign('productType_id')->references('id')->on('product_type');
            $table->unsignedBigInteger('volumes_id');
            $table->foreign('volumes_id')->references('id')->on('volumes');
            $table->unsignedBigInteger('nicotines_id');
            $table->foreign('nicotines_id')->references('id')->on('nicotines');
            $table->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_type_volumes_nicotines');
    }
};
