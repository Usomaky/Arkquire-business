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
           Schema::create('properties', function (Blueprint $table) {
                $table->id();
                $table->string('property_name')->unique();
                $table->boolean('status')->default(true); // Add 'status' column with default value of true
                $table->timestamps();
            });
        // $table->string('property_type');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
