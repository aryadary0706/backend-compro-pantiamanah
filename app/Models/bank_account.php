<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder',
    ];

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }
}
