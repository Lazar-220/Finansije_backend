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
        Schema::create('transakcije', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('novcanik_id')->constrained('novcanici')->cascadeOnDelete();
            $table->foreignId('kategorija_id')->constrained('kategorije')->restrictOnDelete();

            $table->enum('tip',['priliv','odliv']);
            $table->decimal('iznos',15,2);
            $table->date('datum');
            $table->string('opis')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transakcije');
    }
};
