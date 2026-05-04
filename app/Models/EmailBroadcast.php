<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBroadcast extends Model
{
    protected $fillable = [
        'type',
        'audience',
        'event_slug',
        'subject',
        'message',
        'manual_emails',
        'recipient_count',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'manual_emails' => 'array',
            'sent_at' => 'datetime',
        ];
    }
}
