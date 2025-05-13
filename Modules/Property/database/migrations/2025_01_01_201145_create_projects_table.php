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
        Schema::dropIfExists('projects');

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 255)->unique()->index();
            $table->text('short_description');
            $table->longText('description');

            $table->unsignedInteger('visits')->default(0);

            $table->json('features')->nullable();
            $table->enum('construction_type', ['New Construction', 'Established Property'])->nullable()->index();
            
            $table->unsignedSmallInteger('total_blocks')->default(0);
            $table->unsignedSmallInteger('total_buildings')->default(0);
            $table->unsignedSmallInteger('total_floors')->default(0);
            $table->unsignedSmallInteger('total_flats')->default(0);
            $table->unsignedBigInteger('total_area')->default(0);
            $table->unsignedBigInteger('total_area_in_m2')->default(0);
            
            $table->date('project_start_date')->nullable();
            $table->date('project_finish_date')->nullable();
            $table->date('project_sale_start_date')->nullable();
            $table->date('property_availability_date')->nullable();
            
            $table->decimal('lowest_price', 15, 2)->nullable();
            $table->decimal('max_price', 15, 2)->nullable();
            
            $table->string('video_link')->nullable();           
            
            $table->timestamp('publish_start_date')->nullable();
            $table->timestamp('publish_end_date')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('has_ads')->default(false);
            
            $table->enum('moderation_status', ['pending', 'rejected', 'approved'])->default('pending');
            
            $table->foreignId('project_status_id')->nullable()->constrained('project_statuses')->nullOnDelete()->after('visits');
            $table->foreignId('unit_id')->nullable()->constrained('property_length_units')->nullOnDelete()->after('total_area');
            $table->foreignId('developer_id')->nullable()->constrained('property_developers')->nullOnDelete()->after('video_link');
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
        Schema::dropIfExists('projects');
    }
};
