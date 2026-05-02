<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    use HasFactory;

    protected $table = 'anak_asuhs';

    protected $fillable = [
        'name',
        'age',
        'gender',
        'education',
        'badge',
        'description',
        'photo',
    ];
}
