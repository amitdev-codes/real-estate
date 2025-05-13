<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop the table
        Schema::dropIfExists('properties');

        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('short_description');
            $table->longText('description');
            $table->longText('private_notes')->nullable();

            $table->unsignedInteger('visits')->default(0);

            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->unsignedTinyInteger('floors');
            $table->unsignedSmallInteger('area');

            $table->unsignedInteger('base_price')->nullable();
            $table->unsignedInteger('offer_price')->nullable();

            $table->foreignId('property_purpose_id')->constrained('property_purposes')->cascadeOnDelete(); // Property Purpose i.e. For Sale, For Rent etc
            $table->foreignId('project_id')->nullable()->constrained('projects')->cascadeOnDelete(); // Project/Developer id
            $table->foreignId('property_status_id')->constrained('property_statuses')->cascadeOnDelete(); // Property Status i.e. Sold, Leased, Available etc
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete(); // Agent assigned to the property


            $table->json('property_categories')->nullable(); // Property categories i.e. Residential, Commercial, Land etc
            $table->json('features')->nullable();

            $table->json('facilities_distance')->nullable(); // Distance between property and facilites
            $table->json('custom_fields')->nullable();


            $table->boolean('is_featured')->default(false);
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->boolean('has_ads')->default(false);
            $table->enum('moderation_status', ['pending', 'rejected', 'approved'])->default('pending');

            // $table->string('moderation_status')->enum (['pending', 'rejected', 'approved'])->default('pending');

            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('modified_by_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->softDeletes();
            $table->timestamps();

            // Indexing
            $table->index(['is_featured', 'base_price', 'offer_price']);
        });

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
