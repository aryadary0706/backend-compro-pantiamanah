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

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
