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
        Schema::create('category_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('child_id');

            // Foreign key constraints
            $table->foreign('parent_id')->references('id')->on('property_categories')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('property_categories')->onDelete('cascade');

            // Prevent duplicate relationships
            $table->unique(['parent_id', 'child_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_relationships');
    }
};
