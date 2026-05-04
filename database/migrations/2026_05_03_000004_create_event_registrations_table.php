<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table): void {
            $table->id();
            $table->string('event_slug');
            $table->string('event_title');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 40);
            $table->string('organization')->nullable();
            $table->json('responses')->nullable();
            $table->timestamps();

            $table->unique(['event_slug', 'email']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
