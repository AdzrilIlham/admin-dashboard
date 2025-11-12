<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'tags',
        'is_published',
        'published_at',
        'views_count',
        'reading_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'reading_time' => 'integer',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            // Auto-calculate reading time (average 200 words per minute)
            if (empty($blog->reading_time)) {
                $wordCount = str_word_count(strip_tags($blog->content));
                $blog->reading_time = max(1, ceil($wordCount / 200));
            }
        });

        static::updating(function ($blog) {
            // Update slug if title changed
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            // Recalculate reading time if content changed
            if ($blog->isDirty('content')) {
                $wordCount = str_word_count(strip_tags($blog->content));
                $blog->reading_time = max(1, ceil($wordCount / 200));
            }
        });
    }

    /**
     * Scope a query to only include published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to order by latest published.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image) 
            : null;
    }

    /**
     * Increment views count.
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}