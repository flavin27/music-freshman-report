<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Instruments;
use App\Enums\DegreeType;
use App\Enums\Shift;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'instrument',
        'semester',
        'degree_type',
        'campus',
        'shift',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'semester' => 'integer',
        'instrument' => Instruments::class,
        'degree_type' => DegreeType::class,
        'shift' => Shift::class,
    ];
}
