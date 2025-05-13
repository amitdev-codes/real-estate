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
        Schema::create('property_length_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('symbol', 10)->unique();
            $table->text('description')->nullable();
            $table->decimal('conversion_rate', 14, 6)->default(1);
            $table->enum('type', ['length', 'area']);
            $table->unsignedSmallInteger('order_no')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_length_units');
    }
};
