<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::dropIfExists('property_types');

        Schema::create('property_types', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('slug', 255)->unique();
            $table->string('icon')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('property_types')->nullOnDelete()->index(); 
            $table->integer('order_no')->default(1)->unsigned();
            $table->boolean('is_active')->default(true);
            
            $table->softDeletes();            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_types');
    }
};
