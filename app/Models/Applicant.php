<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Instruments;
use App\Enums\DegreeType;
use App\Enums\Shift;

class Applicant extends Model
{
    protected $fillable = [
        'name',
        'instrument',
        'semester',
        'degree_type',
        'campus',
        'shift',
        'approved_first_phase',
        'approved_second_phase',
    ];

    protected $casts = [
        'approved_first_phase' => 'boolean',
        'approved_second_phase' => 'boolean',
        'instrument' => Instruments::class,
        'degree_type' => DegreeType::class,
        'shift' => Shift::class,
    ];
}
