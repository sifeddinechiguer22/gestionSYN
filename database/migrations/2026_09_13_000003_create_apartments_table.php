<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Resident / Owner
            $table->string('number'); // e.g. "14", "A-12"
            $table->integer('floor')->default(0);
            $table->decimal('area_sqm', 8, 2)->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(800.00);
            $table->enum('status', ['occupied', 'vacant'])->default('occupied');
            $table->timestamps();

            $table->index(['building_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
