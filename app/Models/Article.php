<?php

namespace App\Models;

use App\Traits\Search\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'category_id',
        'status',
        'published_at',
        'is_featured',
        'views_count',
        'thumbnail',
        'metadata',
    ];

    protected $casts = [
        'tags' => 'array',
        'metadata' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    // Relations
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getExcerptAttribute($value)
    {
        return $value ?: substr($this->body, 0, 150);
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($value);
    }

    // Custom Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    // Customize the index name
    public function getSearchIndex(): string
    {
        return 'articles_index';
    }

    public function getElasticsearchFields(): array
    {
        return ['title', 'body', 'tags'];
    }

    // Searchable Methods for Elasticsearch
    public function toElasticsearchDocumentArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
        ];
    }

    public function toSearchArray(): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
        ];
    }
}
