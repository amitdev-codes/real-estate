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

        // Schema::dropIfExists('nearby_facility_property_distances');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('nearby_facility_property_distances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('nearby_facility_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('distance')->default(0);
            $table->foreignId('unit_id')->nullable()->constrained('property_length_units')->nullOnDelete();
            $table->unsignedBigInteger('total_area_in_m')->default(0);
            
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
        Schema::dropIfExists('nearby_facility_property_distances');
    }
};
