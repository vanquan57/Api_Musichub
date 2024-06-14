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
        Schema::create('music_videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatarUrl');
            $table->string('videoUrl');
            $table->integer('numPlay')->nullable();
            $table->integer('numDownloads')->nullable();
            $table->unsignedBigInteger('artistId');
            $table->timestamps();
            $table->foreign('artistId')->references('id')->on('artists')->onDelete('cascade');
        });

            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
