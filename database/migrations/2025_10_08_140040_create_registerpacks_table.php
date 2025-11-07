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
        Schema::create('registerpacks', function (Blueprint $table) {
            $table->id();
            $table->string('sklad');
            $table->string('weight');
            $table->string('type');
            $table->string('packages');
            $table->string('cube');
            $table->string('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registerpacks');
    }
};
