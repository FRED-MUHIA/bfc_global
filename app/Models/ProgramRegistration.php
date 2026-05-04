<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramRegistration extends Model
{
    protected $fillable = [
        'program_slug',
        'program_title',
        'cohort',
        'full_name',
        'email',
        'phone',
        'organization',
        'responses',
    ];

    protected function casts(): array
    {
        return [
            'responses' => 'array',
        ];
    }
}
