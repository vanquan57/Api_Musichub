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
        Schema::create('songs', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->text('lyrics')->nullable();
            $table->string('avatarUrl')->nullable();
            $table->string('songUrl');
            $table->integer('numPlay')->nullable();
            $table->integer('numDownloads')->nullable();
            $table->unsignedBigInteger('artistId');
            $table->unsignedBigInteger('albumId');
            $table->unsignedBigInteger('genreId');
            $table->timestamps();
            $table->foreign('artistId')->references('id')->on('artists')->onDelete('cascade');
            $table->foreign('albumId')->references('id')->on('albums')->onDelete('cascade');
            $table->foreign('genreId')->references('id')->on('genres')->onDelete('cascade');
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
