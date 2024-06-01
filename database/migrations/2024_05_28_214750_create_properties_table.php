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
            $table->string('title');
            $table->text('description');
            $table->decimal('price');
            $table->string('rate');
            $table->text('location');
            $table->text('images');
            $table->text('amenities')->nullable();
            $table->string('landmark')->nullable();
            $table->string('mins_away')->nullable();
            $table->text('rules')->nullable();
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
