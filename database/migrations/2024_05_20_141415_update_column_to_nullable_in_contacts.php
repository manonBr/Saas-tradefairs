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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('firstname')->nullable()->change();
            $table->string('function')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('adress')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->longText('notes')->nullable()->change();
            $table->string('siret')->nullable()->change();
            $table->string('tva')->nullable()->change();
            $table->string('newContact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('firstname');
            $table->string('function');
            $table->string('mobile');
            $table->string('phone');
            $table->string('adress');
            $table->string('zipcode');
            $table->string('city');
            $table->string('country');
            $table->longText('notes');
            $table->string('siret');
            $table->string('tva');
            $table->string('newContact');
        });
    }
};
