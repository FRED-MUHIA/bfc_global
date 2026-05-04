<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_registrations', function (Blueprint $table): void {
            $table->id();
            $table->string('program_slug');
            $table->string('program_title');
            $table->string('cohort')->nullable();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('organization')->nullable();
            $table->json('responses')->nullable();
            $table->timestamps();

            $table->unique(['program_slug', 'cohort', 'email'], 'program_registrations_unique_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_registrations');
    }
};
