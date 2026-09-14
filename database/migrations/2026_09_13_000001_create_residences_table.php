<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syndic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('address')->default('Casablanca');
            $table->string('city')->default('Casablanca');
            $table->string('postal_code')->nullable();
            $table->integer('total_apartments')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};
