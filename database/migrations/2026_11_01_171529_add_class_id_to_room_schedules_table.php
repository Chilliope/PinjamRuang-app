<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_schedules', function (Blueprint $table) {
            $table->foreignId('class_id')
                ->nullable()
                ->after('room_id')
                ->constrained('classes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('room_schedules', function (Blueprint $table) {
            $table->dropConstrainedForeignId('class_id');
        });
    }
};
