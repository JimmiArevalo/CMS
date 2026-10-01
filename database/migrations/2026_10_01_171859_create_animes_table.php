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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('title_alt')->nullable();
            $table->text('synopsis')->nullable();
            $table->foreignId('media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->year('year')->nullable();
            $table->string('studio')->nullable();
            $table->enum('type', ['Serie', 'Película', 'OVA', 'ONA'])->default('Serie');
            $table->enum('status', ['En emisión', 'Finalizado', 'Próximo', 'Pausado', 'Cancelado'])->default('Próximo');
            $table->unsignedTinyInteger('seasons')->default(1);
            $table->date('aired_from')->nullable();
            $table->date('aired_to')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_classic')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
