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
       Schema::create('users', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('phone')->unique();
        $table->string('name')->nullable();
        $table->enum('role', ['client', 'staff', 'admin'])->default('client');
        $table->timestamp('phone_verified_at')->nullable();
        $table->unsignedInteger('no_show_count')->default(0);
        $table->unsignedInteger('late_cancel_count')->default(0);
        $table->boolean('is_blocked')->default(false);
        $table->rememberToken();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
