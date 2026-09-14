<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('description');
        });

        // Modify status column type to string if needed or update existing enum values
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('status')->default('déposée')->change();
        });

        // Update existing records to new statuses
        DB::table('complaints')->where('status', 'open')->update(['status' => 'déposée']);
        DB::table('complaints')->where('status', 'in_progress')->update(['status' => 'en_attente']);
        DB::table('complaints')->where('status', 'resolved')->update(['status' => 'avec_succès']);
        DB::table('complaints')->where('status', 'closed')->update(['status' => 'refusée']);
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
            $table->string('status')->default('open')->change();
        });
    }
};
