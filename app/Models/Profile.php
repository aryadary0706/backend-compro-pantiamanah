<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'email_information',
        'phone_number',
        'Whatsapp_number',
        'contact_information',
        'Operational_information',
        'qris_code',
        'whatsapp_link',
        'Updated_at',
    ];

    protected $appends = ['qris_url'];

    public function getQrisUrlAttribute()
    {
        return $this->qris_code
            ? asset('storage/' . $this->qris_code)
            : null;
    }
}
