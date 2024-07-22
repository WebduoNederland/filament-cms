<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('filament_cms_blogs', function (Blueprint $table): void {
            $table->index('published');
            $table->index('publish_date');
        });
    }

    public function down(): void
    {
        Schema::table('filament_cms_blogs', function (Blueprint $table): void {
            $table->dropIndex([
                'filament_cms_blogs_published_index',
                'filament_cms_blogs_publish_date_index',
            ]);
        });
    }
};
