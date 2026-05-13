<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    protected $fillable = [
        'user_id', 'book_id', 'status',
        'current_page', 'started_at', 'finished_at'
    ];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}