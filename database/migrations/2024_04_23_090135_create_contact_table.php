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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('company');
            $table->string('function');
            $table->string('mobile');
            $table->string('phone');
            $table->string('email');
            $table->string('adress');
            $table->string('zipcode');
            $table->string('city');
            $table->string('country');
            $table->longText('notes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact');
    }
};
