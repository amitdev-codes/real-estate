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
        Schema::dropIfExists('agents');

        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->cascadeOnDelete();
            $table->string('license_number', 50)->unique();
            $table->string('email')->unique();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->longText('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexing
            $table->index('agency_id');
        });

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
