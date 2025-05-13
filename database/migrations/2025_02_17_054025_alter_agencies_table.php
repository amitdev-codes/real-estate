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
        Schema::table('agencies', function (Blueprint $table) {
            //
            // $table->dropColumn(['agency_id']);
            $table->enum('type', ['residential', 'commercial', 'luxury', 'property_management', 'investment', 'relocation'])->default('residential')->after('slug');
            $table->string('location')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            //
            $table->dropColumn(['type', 'location']);
        });
    }
};
