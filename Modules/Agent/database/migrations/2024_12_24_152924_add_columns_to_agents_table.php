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
        Schema::table('agents', function (Blueprint $table) {
            $table->json('specializations')->nullable()->after('license_number');
            $table->string('primary_area')->nullable()->after('specializations');
            $table->json('additional_areas')->nullable()->after('primary_area');
            $table->smallInteger('experience')->unsigned()->nullable()->after('additional_areas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'specializations',
                'additional_areas',
                'primary_area',
                'experience'
            ]);
        });
    }
};
