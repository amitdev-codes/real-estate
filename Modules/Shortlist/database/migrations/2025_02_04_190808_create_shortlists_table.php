<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shortlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->onDelete('set null');
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('set null');
            $table->morphs('shortlistable'); // Allows shortlisting of different types (Properties, etc.)
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Prevent duplicate entries
            $table->unique(['user_id', 'shortlistable_id', 'shortlistable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shortlists');
    }
};
