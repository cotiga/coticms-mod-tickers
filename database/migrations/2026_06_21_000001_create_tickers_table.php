<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->id();
            $table->string('texte', 255);
            $table->string('lien', 255)->nullable();
            $table->unsignedSmallInteger('ordre')->default(0);
            $table->boolean('onl')->default(true);
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickers');
    }
};
