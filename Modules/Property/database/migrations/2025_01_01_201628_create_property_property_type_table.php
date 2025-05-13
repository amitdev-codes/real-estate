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
        // Schema::dropIfExists('property_property_type');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('property_property_type', function (Blueprint $table) {

            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('cascade');
               
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_property_type');
    }
};
