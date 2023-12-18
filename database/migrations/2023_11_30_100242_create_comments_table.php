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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('post_id');
            // $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->timestamps();

            //Ovo je foreign_key Constraint
            //Za post_id kljuc koji je strani postoji referenca 
            //na 'posts' tableu i kolonu 'id'
            //akcija: cascade and delete all associated posts on delete.
            $table->foreign('post_id')->references('id')->on('post')->cascadeOnDelete();
           //Takodje imamo strani kljuc iz 'users' tabele
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            //Prve dve dole linije mozemo da zamenimo sa trecom linijom.
            // Ostajem pri duzoj varijanti sa dve linije
            // 1. line $table->unsignedBigInteger('post_id');
            // 2. line $table->foreign('post_id')->references('id')->on('post')->cascadeOnDelete();
            // 3. line $table->foreignId('post_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
