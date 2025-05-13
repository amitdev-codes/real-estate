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
            $table->string('slug')->unique()->index();
            $table->text('short_description');
            $table->longText('description');
            $table->text('private_notes')->nullable();

            $table->unsignedInteger('visits')->default(0);

            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedTinyInteger('floors')->nullable();
            $table->unsignedTinyInteger('parkings')->nullable();

            $table->unsignedInteger('area')->nullable();
            $table->unsignedBigInteger('total_area_in_m2')->default(0);
            
            $table->decimal('base_price', 15, 2)->nullable()->index();
            $table->decimal('offer_price', 15, 2)->nullable()->index();
            
            $table->enum('construction_type', ['New Construction', 'Established Property'])->nullable()->index();
            $table->json('features')->nullable();
            
            $table->json('custom_fields')->nullable();
            
            $table->string('video_link')->nullable();
            
            $table->date('property_availability_date')->nullable();
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('has_ads')->default(false);
            
            $table->enum('moderation_status', ['pending', 'rejected', 'approved'])->default('pending');            
            
            $table->foreignId('unit_id')->nullable()->constrained('property_length_units')->nullOnDelete()->after('area');
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete()->after('offer_price');
            $table->foreignId('property_status_id')->nullable()->constrained('property_statuses')->nullOnDelete()->after('project_id');
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('created_by_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->foreignId('modified_by_id')->nullable()->constrained('agents')->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
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
