<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyEnquiriesTable extends Migration
{
    public function up()
    {
        Schema::create('property_enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('postcode')->nullable();
            $table->enum('preferred_contact_method', ['email', 'phone', 'both'])->default('email');
            $table->json('enquiry_type_id')->nullable(); // Can store multiple or a single ID
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('property_enquiries');
    }
}
