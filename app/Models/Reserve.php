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
    // public function investment()
    // {
    //     return $this->belongsTo(Investment::class);
    // }
    // public function paymentType()
    // {
    //     return $this->belongsTo(PaymentType::class);
    // }
    // public function expenser()
    // {
    //     return $this->belongsTo(Expense::class, 'expense_id');
    // }


    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymenttype()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function investment()
    {
        return $this->belongsTo(Investment::class, 'investment_id');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    public function expenser()
    {
        return $this->hasOneThrough(User::class, Expense::class, 'id', 'id', 'expense_id', 'expenser_id');
    }
}
