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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('property_developers', function (Blueprint $table) {
            $table->id();
            
            $table->string('developer_name');
            $table->string('developer_email')->unique()->index();
            $table->string('developer_phone')->nullable();
            $table->string('developer_website')->nullable();

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
        Schema::dropIfExists('property_developers');
    }
};
