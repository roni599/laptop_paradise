<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'product_id', 
        'stock_date', 
        'buying_price', 
        'selling_price', 
        'stock_quantity', 
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
}
