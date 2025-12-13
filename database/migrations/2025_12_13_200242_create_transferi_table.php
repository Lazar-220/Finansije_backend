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
        Schema::create('transferi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('novcanik_iz_id')->constrained('novcanici')->cascadeOnDelete();
            $table->foreignId('novcanik_u_id')->constrained('novcanici')->cascadeOnDelete();
            $table->decimal('iznos',15,2);
            $table->string('valuta',10)->default('RSD');
            $table->decimal('provizija',15,2)->default(0);
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
        Schema::dropIfExists('transferi');
    }
};
