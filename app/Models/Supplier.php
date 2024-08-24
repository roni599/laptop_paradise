<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'image',
        'shopname',
        'user_id', // Foreign key for User
        'product_id', // Foreign key for Product
    ];

    // Define the relationship with the User model (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Product model (Many-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
