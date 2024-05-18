<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filament_cms_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('from_slug')->index();
            $table->string('to');
            $table->string('type');
            $table->integer('hits')->default(0);
            $table->dateTime('last_hit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_cms_redirects');
    }
};
