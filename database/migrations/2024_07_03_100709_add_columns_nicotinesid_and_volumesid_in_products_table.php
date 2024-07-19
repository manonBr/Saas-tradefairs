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
            $table->unsignedBigInteger('volumes_id');
            $table->foreign('volumes_id')->references('id')->on('volumes');
            $table->unsignedBigInteger('nicotines_id');
            $table->foreign('nicotines_id')->references('id')->on('nicotines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['volumes_id']);
            $table->dropColumn('volumes_id');
            $table->dropForeign(['nicotines_id']);
            $table->dropColumn('nicotines_id');
        });
    }
};
