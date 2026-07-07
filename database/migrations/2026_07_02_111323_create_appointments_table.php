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
    Schema::create('appointments', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->foreignUuid('client_id')->constrained('users')->restrictOnDelete();
        $table->foreignUuid('staff_id')->constrained('staff')->restrictOnDelete();
        $table->foreignUuid('service_id')->constrained('services')->restrictOnDelete();
        $table->timestampTz('start_datetime');
        $table->timestampTz('end_datetime');
        $table->enum('status', [
            'pending',
            'confirmed',
            'cancelled_by_client',
            'cancelled_by_staff',
            'completed',
            'no_show',
        ])->default('pending');
        $table->timestampTz('cancelled_at')->nullable();
        $table->enum('cancelled_by', ['client', 'staff'])->nullable();
        $table->text('cancellation_reason')->nullable();
        $table->timestamps();
    });

    // Sprečava preklapanje termina istog frizera na nivou baze
    DB::statement('
        ALTER TABLE appointments
        ADD CONSTRAINT no_overlapping_appointments
        EXCLUDE USING gist (
            staff_id WITH =,
            tstzrange(start_datetime, end_datetime) WITH &&
        ) WHERE (status IN (\'pending\', \'confirmed\'))
    ');
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        DB::statement('ALTER TABLE appointments DROP CONSTRAINT IF EXISTS no_overlapping_appointments');
    });
    Schema::dropIfExists('appointments');
}
};
