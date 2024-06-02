<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'permissions',
    ];    
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'permissions' => 'array',
    ];
    
    /**
     * Get all of the tags for the post.
     */
    public function users(): MorphToMany
    {
        return $this->belongsToMany(User::class);
    }
}
