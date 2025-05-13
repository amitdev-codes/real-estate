<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        Schema::dropIfExists('agencies');

        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description')->nullable();
            $table->string('email')->unique();
            // $table->string('agency_id')->nullable();
            $table->string('registered_agency_number')->nullable();
            $table->string('website')->unique();
            $table->string('phone');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('modified_by_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->longText('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // Indexing
            $table->index('email');
            $table->index('phone');
        });

         // Enable foreign key checks
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
