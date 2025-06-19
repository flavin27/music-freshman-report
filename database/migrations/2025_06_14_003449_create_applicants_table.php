<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Instruments;
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
            $table->enum('instrument', array_column(Instruments::cases(), 'value'));
            $table->string('semester');
            $table->string('campus')->default('Escola de Música');
            $table->enum("degree_type", array_column(DegreeType::cases(), 'value'));
            $table->enum("shift", array_column(Shift::cases(), 'value'))->default(Shift::Integral->value);
            $table->boolean('is_approved')->default(false);
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
