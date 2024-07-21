<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filament_cms_blogs', function (Blueprint $table): void {
            $table->id();
            $table->json('name')->default(new Expression('(JSON_ARRAY())'));
            $table->json('slug')->default(new Expression('(JSON_ARRAY())'));
            $table->json('content')->default(new Expression('(JSON_ARRAY())'));
            $table->json('images')->default(new Expression('(JSON_ARRAY())'));
            $table->dateTime('publish_date');
            $table->boolean('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_cms_blogs');
    }
};
