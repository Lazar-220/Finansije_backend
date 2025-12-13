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
        Schema::create('kategorije', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('roditelj_id')->nullable()->constrained('kategorije')->nullOnDelete();
            
            $table->string('naziv');//hrana,plata,hobi
            $table->enum('tip',['priliv','odliv']);//obavezno
            $table->string('boja',30)->nullable();
            $table->string('ikonica',50)->nullable();
            $table->boolean('aktivna')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategorije');
    }
};
