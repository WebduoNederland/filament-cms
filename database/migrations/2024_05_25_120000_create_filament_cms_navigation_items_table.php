<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('filament_cms_navigation_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('value');
            $table->integer('sort')->default(0);
            $table->boolean('has_sub_items');
            $table->json('sub_items');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filament_cms_navigation_items');
    }
};
