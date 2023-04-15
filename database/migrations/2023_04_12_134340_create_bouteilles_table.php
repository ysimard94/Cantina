<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bouteilles', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->string('photo');
            $table->string('code_saq');
            $table->string('prix');
            $table->string('note');
            $table->string('nbr_notes');
            $table->unsignedBigInteger('pays_id');
            $table->unsignedBigInteger('categorie_id');
            $table->string('url_saq');
            $table->string('annee')->nullable();
            $table->timestamps();

            $table->foreign('pays_id')
                ->references('id')
                ->on('pays')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('bouteilles', function (Blueprint $table) {
            $table->dropForeign(['pays_id']);
            $table->dropForeign(['categorie_id']);
        });

        Schema::dropIfExists('bouteilles');
    }
};
