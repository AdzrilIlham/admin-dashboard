<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMe extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'about_me';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'profile_image',
        'resume_file',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'instagram_url',
        'email',
        'phone',
        'location',
        'years_of_experience',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'years_of_experience' => 'integer',
    ];

    /**
     * Get the profile image URL.
     */
    public function getProfileImageUrlAttribute(): ?string
    {
        return $this->profile_image 
            ? asset('storage/' . $this->profile_image) 
            : null;
    }

    /**
     * Get the resume file URL.
     */
    public function getResumeFileUrlAttribute(): ?string
    {
        return $this->resume_file 
            ? asset('storage/' . $this->resume_file) 
            : null;
    }
}