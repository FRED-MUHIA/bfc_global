<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_broadcasts', function (Blueprint $table): void {
            $table->id();
            $table->string('type');
            $table->string('audience');
            $table->string('event_slug')->nullable();
            $table->string('subject');
            $table->longText('message');
            $table->json('manual_emails')->nullable();
            $table->unsignedInteger('recipient_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_broadcasts');
    }
};
