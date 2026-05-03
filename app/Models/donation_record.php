<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'phone_number',
        'tujuan',
        'donasi_id',
        'bank_account_id',
        'amount',
        'payment_proof',
    ];

    /* ================= RELATIONS ================= */

    public function need()
    {
        return $this->belongsTo(Need::class, 'donasi_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
