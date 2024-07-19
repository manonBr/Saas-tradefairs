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
        Schema::table('product_type', function (Blueprint $table) {
            $table->unsignedBigInteger('volumes_id')->default(7);
            $table->foreign('volumes_id')->references('id')->on('volumes');
            $table->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_type', function (Blueprint $table) {
            $table->dropColumn('volumes_id');
            $table->dropColumn('active');
        });
    }
};
