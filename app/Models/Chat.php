<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'category_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
