<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'isbn', 'cover_url',
        'description', 'genre', 'total_pages', 'added_by'
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}