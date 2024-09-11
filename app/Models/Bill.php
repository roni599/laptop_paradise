<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'bills';

    // The attributes that are mass assignable.
    protected $fillable = [
        'total_price',
        'quantity',
        'price',
        'status',
        'customer_id',
        'paymenttype_id',
        'user_id',
        'serial_id',
    ];

    // Define relationships if necessary
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }
}
