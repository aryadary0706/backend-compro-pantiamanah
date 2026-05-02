<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'Updated_at', // Kolom manual untuk tracking
    ];

    // Boot method untuk update kolom 'Updated_at' secara otomatis saat ada perubahan
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->Updated_at = now();
        });
    }

    // Otomatis kasih URL lengkap untuk QRIS
    public function getQrisUrlAttribute()
    {
        return $this->qris_code
            ? asset('storage/' . $this->qris_code)
            : null;
    }

    protected $appends = ['qris_url'];
}
