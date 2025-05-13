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
        // Drop the 'notification_groups' table if it exists
        Schema::dropIfExists('notifications');
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('postcode')->nullable();
            $table->foreignId('notification_group_id')->constrained('notification_groups');
            $table->json('notification_sub_group_ids')->nullable();
            $table->foreignId('property_id')->nullable()->constrained();
            $table->text('data')->nullable();
            $table->morphs('notifiable');
            $table->timestamp('read_at')->nullable();
            $table->text('reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
