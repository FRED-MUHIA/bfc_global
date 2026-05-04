<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipInquiry extends Model
{
    protected $fillable = [
        'organization_name',
        'contact_name',
        'email',
        'phone',
        'partnership_goals',
    ];
}
