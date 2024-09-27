<?php

use App\Enums\BusinessTypes;
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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
                ->onDelete('cascade');
            $table->string('business_name');
            $table->string('business_year');
            $table->string('business_number');
            $table->string('business_type')->default(BusinessTypes::Physical->value);
            $table->string('listing_id')->nullable();
            // $table->string('property_type');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('property_id');
            $table->text('description');
            $table->string('transaction_type');
            $table->text('address');
            $table->text('lga')->nullable();;
            $table->text('city')->nullable();;
            $table->text('state')->nullable();;
            $table->text('country')->nullable();;
            $table->text('landmark')->nullable();;
            $table->double('price');
            $table->double('bid')->default(0);
            $table->double('profit_margin');
            $table->string('staffs');
            $table->unsignedBigInteger('age');
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamp('ends')->nullable();
            $table->enum('verification_status', ['verified', 'unverified'])
                ->default('unverified');
            $table->enum('status', ['review', 'approved', 'rejected'])
                ->default('review');
            $table->enum('business_status', ['unsold', 'sold']);
            $table->boolean('business_state')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
