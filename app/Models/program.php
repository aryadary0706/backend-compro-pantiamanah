<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'images',
        'date',
        'location',
        'time'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->images ? asset('storage/' . $this->images) : null;
    }
}
