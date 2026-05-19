<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class AnakAsuh extends Model
{
    use HasFactory;

    protected $table = 'anak_asuhs';

    protected $fillable = [
        'name',
        'age',
        'tanggal_lahir',
        'tempat_lahir',
        'gender',
        'education',
        'education_level',
        'status',
        'description',
        'photo',
    ];

    protected $appends = ['photo_url'];

    // photo asli di DB tetap 'anak_asuh/foto.jpg' (aman untuk didelete)
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
