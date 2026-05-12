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
        'Updated_at',
    ];
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->Updated_at = now();
        });
    }

    protected $appends = ['qris_url'];

    public function getImageUrlAttribute()
    {
        return $this->qris_code ? asset('storage/' . $this->qris_code) : null;
    }
}
