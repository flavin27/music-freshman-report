<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstPhaseResults extends Model
{
    protected $table = 'first_phase_results';

    protected $fillable = [
        'id',
        'url',
        'updated_at',
    ];

}
