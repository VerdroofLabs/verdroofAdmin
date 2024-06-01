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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('school')->nullable();
            $table->string('work')->nullable();
            $table->string('image_url')->nullable();
            $table->string('birthday')->nullable();
            $table->string('favorite_song')->nullable();
            $table->string('home')->nullable();
            $table->string('pet')->nullable();
            $table->string('obsessed_with')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
