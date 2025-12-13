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
        Schema::create('novcanici', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id')->constrained('users')->cascadeOnDelete();

            $table->string('naziv');
            $table->enum('tip',['banka','kes','stednja','kripto','ostalo'])->default('ostalo');
            $table->string('valuta',3)->default('RSD');
            $table->decimal('pocetno_stanje',15,2)->default(0);
            $table->decimal('trenutno_stanje',15,2)->default(0);
            $table->boolean('aktivan')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novcanici');
    }
};
