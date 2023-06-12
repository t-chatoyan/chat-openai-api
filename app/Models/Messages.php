<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'is_default',
        'chat_id',
        'customer_id',
        'is_user',
        'created_at',
    ];

    protected $appends = ['type'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    /**
     * @return string
     */
    public function getTypeAttribute()
    {
        return $this->is_user ? 'Question' : 'Answer';

    }
}
