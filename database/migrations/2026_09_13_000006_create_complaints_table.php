<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Resident author
            $table->string('ticket_number')->unique(); // e.g. "TK-2026-001"
            $table->string('title');
            $table->enum('category', ['plumbing', 'elevator', 'electricity', 'noise', 'cleanliness', 'other'])->default('other');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
