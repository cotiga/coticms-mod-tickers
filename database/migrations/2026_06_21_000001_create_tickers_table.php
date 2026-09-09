<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Table `tickers` à son état final — création consolidée (2026-09-09).
 *
 * Remplace la création d'origine et toutes ses retouches. Ne fait rien là où la
 * table existe déjà : les sites en place gardent leur schéma, seule une
 * installation neuve passe par ici.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tickers')) {
            return;
        }

        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->string('texte');
            $table->string('lien')->nullable();
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->boolean('onl')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};
