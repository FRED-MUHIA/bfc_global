<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_slug',
        'event_title',
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
