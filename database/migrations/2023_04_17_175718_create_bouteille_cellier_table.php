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
        // Créer la table bouteille_cellier (pivot)
        Schema::create('bouteille_cellier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cellier_id');
            $table->unsignedBigInteger('bouteille_id');
            $table->timestamps();

            $table->foreign('cellier_id')->references('id')->on('celliers')->onDelete('cascade');
            $table->foreign('bouteille_id')->references('id')->on('bouteilles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouteille_cellier');
    }
};
