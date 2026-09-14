<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residence_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Author
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['info', 'urgent', 'event', 'maintenance'])->default('info');
            $table->boolean('pinned')->default(false);
            $table->timestamp('published_at')->useCurrent();
            $table->timestamps();

            $table->index(['residence_id', 'pinned', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
