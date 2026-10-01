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
        Schema::table('news', function (Blueprint $table) {
            if (! Schema::hasColumn('news', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            }

            if (! Schema::hasColumn('news', 'anime_id')) {
                $table->foreignId('anime_id')->nullable()->constrained('animes')->nullOnDelete();
            }

            if (! Schema::hasColumn('news', 'author')) {
                $table->string('author')->nullable();
            }

            if (! Schema::hasColumn('news', 'status')) {
                $table->string('status')->default('borrador');
            }

            if (! Schema::hasColumn('news', 'published_at')) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'published_at')) {
                $table->dropColumn('published_at');
            }

            if (Schema::hasColumn('news', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('news', 'author')) {
                $table->dropColumn('author');
            }

            if (Schema::hasColumn('news', 'anime_id')) {
                $table->dropConstrainedForeignId('anime_id');
            }

            if (Schema::hasColumn('news', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }
        });
    }
};
