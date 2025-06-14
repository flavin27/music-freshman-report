<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Instrumentos;
use App\Enums\DegreeType;
use App\Enums\Shift;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('instrumentos', array_column(Instrumentos::cases(), 'value'));
            $table->string('semester');
            $table->string('campus');
            $table->enum("degree_type", array_column(DegreeType::cases(), 'value'));
            $table->enum("shift", array_column(Shift::cases(), 'value'));
            $table->boolean('approved_first_phase')->default(false);
            $table->boolean('approved_second_phase')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
