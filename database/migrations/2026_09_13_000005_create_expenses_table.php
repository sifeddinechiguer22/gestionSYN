<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residence_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('category', ['maintenance', 'electricity', 'water', 'cleaning', 'security', 'repairs', 'other'])->default('maintenance');
            $table->decimal('amount', 10, 2);
            $table->date('expense_date');
            $table->string('vendor_name')->nullable();
            $table->string('receipt_file')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['residence_id', 'expense_date', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
