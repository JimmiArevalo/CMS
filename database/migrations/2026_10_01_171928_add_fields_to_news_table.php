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
            $table->foreignId('category_id')->nullable()->after('media_id')->constrained('categories')->nullOnDelete();
            $table->foreignId('anime_id')->nullable()->after('category_id')->constrained('animes')->nullOnDelete();
            $table->string('author')->nullable()->after('anime_id');
            $table->string('status')->default('borrador')->after('author');
            $table->timestamp('published_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('anime_id');
            $table->dropColumn(['author', 'status', 'published_at']);
        });
    }
};
