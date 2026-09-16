<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Payer / Resident
            $table->string('receipt_number')->unique(); // e.g. "REC-2026-001"
            $table->decimal('amount', 10, 2);
            $table->string('month'); // e.g. "2026-09" or "Septembre 2026"
            $table->date('payment_date');
            $table->enum('payment_method', ['virement', 'especes', 'cheque', 'carte'])->default('virement');
            $table->enum('status', ['paid', 'pending', 'late', 'cancelled'])->default('paid');
            $table->string('reference')->nullable();
            $table->string('proof_file')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['apartment_id', 'status', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
