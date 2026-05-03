<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasis';

    protected $fillable = [
        'title',
        'description',
        'photo',
        'bank_account_id',
        'target_amount',
        'collected_amount',
    ];

    // MANY Donasi -> ONE BankAccount
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
