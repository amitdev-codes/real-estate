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
        Schema::dropIfExists('meta_contents');

        Schema::create('meta_contents', function (Blueprint $table) {
            $table->id();

            $table->morphs('meta_contentable');

            $table->string('seo_title');
            $table->string('seo_description')->nullable();
            $table->enum('index', ['noindex', 'index'])->default('noindex');
            $table->boolean('seo_indexing')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_contents');
    }
};
