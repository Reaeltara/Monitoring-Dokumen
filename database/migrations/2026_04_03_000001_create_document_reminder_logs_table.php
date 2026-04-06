<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('offset_days');
            $table->date('sent_date');
            $table->string('status', 20);
            $table->text('response')->nullable();
            $table->timestamps();

            $table->unique(['document_id', 'offset_days', 'sent_date'], 'reminder_unique_per_day');
            $table->index(['user_id', 'sent_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_reminder_logs');
    }
};
