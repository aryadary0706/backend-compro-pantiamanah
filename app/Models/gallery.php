<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'image_path',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'date',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
