<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('major_id')
                ->constrained('majors')
                ->cascadeOnDelete();

            $table->string('class_name');
            $table->unsignedTinyInteger('semester');

            $table->timestamps();

            $table->unique(['major_id', 'class_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
