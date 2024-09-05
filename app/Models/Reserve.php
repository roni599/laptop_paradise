<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_type',
        'amount',
        'status',
        'investment_id',
        'payment_type_id',
        'user_id',
    ];
    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
