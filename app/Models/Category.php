<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description',
    ];

    // Relations
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    // Scopes
    public function scopeWithArticles($query)
    {
        return $query->with('articles');
    }

    // Custom Methods
    public function articleCount()
    {
        return $this->articles()->count();
    }
}
