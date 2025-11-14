<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $fillable = [
    'title', 'slug', 'description', 'cover_image', 
    'language', 'is_published', 'host_id', 'category_id'
    ];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
