<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relations
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    // Accessors
    public function getInitialsAttribute()
    {
        return collect(explode(' ', $this->name))->map(function ($segment) {
            return $segment[0];
        })->join('');
    }

    // Custom Methods
    public function publishArticle($articleData)
    {
        return $this->articles()->create(array_merge($articleData, ['status' => 'published']));
    }
}
