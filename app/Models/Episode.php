<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'audio_file', 'duration',
        'published_at', 'is_published', 'podcast_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function podcast()
    {
        return $this->belongsTo(Podcast::class);
    }
}
