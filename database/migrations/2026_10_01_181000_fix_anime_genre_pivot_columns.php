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
        Schema::table('anime_genre', function (Blueprint $table) {
            if (! Schema::hasColumn('anime_genre', 'anime_id')) {
                $table->foreignId('anime_id')->nullable()->constrained('animes')->cascadeOnDelete();
            }

            if (! Schema::hasColumn('anime_genre', 'genre_id')) {
                $table->foreignId('genre_id')->nullable()->constrained('genres')->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anime_genre', function (Blueprint $table) {
            if (Schema::hasColumn('anime_genre', 'genre_id')) {
                $table->dropConstrainedForeignId('genre_id');
            }

            if (Schema::hasColumn('anime_genre', 'anime_id')) {
                $table->dropConstrainedForeignId('anime_id');
            }
        });
    }
};
