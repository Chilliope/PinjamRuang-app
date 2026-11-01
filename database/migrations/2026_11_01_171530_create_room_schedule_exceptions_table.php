<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_schedule_exceptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_schedule_id')
                ->constrained('room_schedules')
                ->cascadeOnDelete();

            // Tanggal jadwal rutin yang ingin dilepas
            $table->date('exception_date');

            // online, postponed, cancelled, rescheduled
            $table->string('type', 30);

            $table->text('reason');

            // Informasi jadwal pengganti, jika ada
            $table->foreignId('replacement_room_id')
                ->nullable()
                ->constrained('rooms')
                ->nullOnDelete();

            $table->date('replacement_date')->nullable();
            $table->time('replacement_start_time')->nullable();
            $table->time('replacement_end_time')->nullable();

            // pending, approved, rejected
            $table->string('status', 20)->default('pending');

            // Pengaju dan Staff yang memeriksa
            $table->foreignId('requested_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index(['exception_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_schedule_exceptions');
    }
};
