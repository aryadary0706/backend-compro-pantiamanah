<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    protected $table = 'needs';

    protected $fillable = [
        'title',
        'description',
        'photo',
        'bank_account_id',
        'target_amount',
        'collected_amount',
    ];

    protected $appends = [
        'photo_url'
    ];

    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : null;
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
