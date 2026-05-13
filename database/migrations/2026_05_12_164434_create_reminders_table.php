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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pensioner_id')->constrained()->onDelete('cascade');
            $table->string('type'); // authentication, payment, renewal
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('remind_at');
            $table->dateTime('sent_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed', 'cancelled'])->default('pending');
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['status', 'remind_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
