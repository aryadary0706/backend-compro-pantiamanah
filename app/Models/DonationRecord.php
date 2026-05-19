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
        'payment_method',
        'bank_account_id',
        'amount',
        'payment_proof',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
    protected $appends = [
        'payment_proof_url'
    ];

    public function getPaymentProofUrlAttribute()
    {
        return $this->payment_proof
            ? asset('storage/' . $this->payment_proof)
            : null;
    }
}
