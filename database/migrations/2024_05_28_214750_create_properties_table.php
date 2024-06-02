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
            $table->foreignId('user_id');
            $table->string('apartment_type')->nullable();
            $table->text('unit_type')->nullable();
            $table->string('rent')->nullable();
            $table->string('unit_floor')->nullable();
            $table->string('unit_size')->nullable();
            $table->string('no_of_bedrooms')->nullable();
            $table->string('no_of_bathrooms')->nullable();
            $table->text('location')->nullable();
            $table->text('cover_image')->nullable();
            $table->text('other_images')->nullable();
            $table->text('basic_amenities')->nullable();
            $table->text('building_amenities')->nullable();
            $table->text('safety_amenities')->nullable();
            $table->text('house_rules')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_schedule')->nullable();
            $table->string('utility_deposit')->nullable();
            $table->string('security_deposit')->nullable();
            $table->boolean('published')->default(0);
            $table->string('property_id', 20)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
