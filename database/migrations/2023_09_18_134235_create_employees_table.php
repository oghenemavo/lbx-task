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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->uuid('employee_id')->unique();
            $table->string('username')->unique();
            $table->string('name_prefix');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('date_of_birth');
            $table->string('time_of_birth');
            $table->decimal('age');
            $table->string('employment_date');
            $table->decimal('employment_duration');
            $table->string('phone_number');
            $table->string('location');
            $table->string('county');
            $table->string('city');
            $table->string('zip');
            $table->string('region');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
