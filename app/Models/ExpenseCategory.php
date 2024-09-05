<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_name', 'images', 'status', 'user_id'];

    /**
     * Get the user that owns the expense category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
