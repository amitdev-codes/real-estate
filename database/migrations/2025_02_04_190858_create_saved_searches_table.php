<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saved_searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable(); // Custom name for the search
            $table->json('search_criteria'); // Store search filters as JSON
            $table->text('description')->nullable();
            $table->boolean('is_alert')->default(false); // Option for search alerts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saved_searches');
    }
};
