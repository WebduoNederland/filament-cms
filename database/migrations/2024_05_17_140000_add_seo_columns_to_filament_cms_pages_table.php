<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filament_cms_pages', function (Blueprint $table) {
            $table->after('status', function (Blueprint $table) {
                $table->string('meta_title');
                $table->text('meta_description')->nullable();
                $table->string('meta_robots')->nullable();
                $table->string('meta_og_image')->nullable();
            });
        });
    }

    public function down(): void
    {
        Schema::table('filament_cms_pages', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title',
                'meta_description',
                'meta_robots',
                'meta_og_image',
            ]);
        });
    }
};
