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
        // Créer la table bouteille_celier (pivot)
        Schema::create('bouteille_celier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('celier_id');
            $table->unsignedBigInteger('bouteille_id');
            $table->timestamps();
        
            $table->foreign('celier_id')->references('id')->on('celiers')->onDelete('cascade');
            $table->foreign('bouteille_id')->references('id')->on('bouteilles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouteille_celier');
    }
};
