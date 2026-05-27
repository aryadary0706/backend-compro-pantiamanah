<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'ketua_yayasan',
        'tahun_periode',
        'profil_text',
        'email',
        'phone_number',
        'Whatsapp_number',
        'Operational_information',
        'qris_code',
        'whatsapp_link',
        'instagram',
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
