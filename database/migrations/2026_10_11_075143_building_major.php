
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('building_major', function (Blueprint $table) {
            $table->id();

            $table->foreignId('building_id')
                ->constrained('buildings')
                ->cascadeOnDelete();

            $table->foreignId('major_id')
                ->constrained('majors')
                ->cascadeOnDelete();

            $table->unique(['building_id', 'major_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('building_major');
    }
};
