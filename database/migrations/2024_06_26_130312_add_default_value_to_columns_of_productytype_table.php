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
            $table->boolean('active')->default(1)->change();
            $table->integer('order')->default(10)->change();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_type', function (Blueprint $table) {
            $table->boolean('active');
            $table->integer('order');
        });
    }
};
