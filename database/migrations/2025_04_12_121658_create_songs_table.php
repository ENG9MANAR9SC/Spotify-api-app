<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();

            $table->string('spotify_id')->unique();
            $table->string('name');
            $table->string('artist');
            $table->string('album')->nullable();
            $table->integer('duration_ms')->nullable();
            $table->string('release_year')->nullable();
            $table->float('loudness')->nullable();
            $table->float('tempo')->nullable();
            $table->float('danceability')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
