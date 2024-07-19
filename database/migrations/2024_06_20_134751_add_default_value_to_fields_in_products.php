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
            $table->integer('volume')->default(10)->change();
            $table->integer('nicotine')->default(0)->change();
            $table->float('specificPrice', 8,2)->default(0.0)->change();
            $table->boolean('active')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('volume')->change();
            $table->integer('nicotine')->change();
            $table->float('specificPrice', 8,2)->defaul->change();
            $table->boolean('active')->change();
        });
    }
};
