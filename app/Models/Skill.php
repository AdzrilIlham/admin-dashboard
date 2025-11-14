<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level', 
        'user_id',
        'icon',
        'proficiency'
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-assign user_id ketika membuat skill baru
        static::creating(function ($skill) {
            if (Auth::check() && empty($skill->user_id)) {
                $skill->user_id = Auth::id();
            }
            
            // Auto-set proficiency berdasarkan level
            if (empty($skill->proficiency)) {
                $skill->proficiency = $skill->getProficiencyLevel($skill->level);
            }
        });

        // Auto-update proficiency ketika level berubah
        static::updating(function ($skill) {
            if ($skill->isDirty('level')) {
                $skill->proficiency = $skill->getProficiencyLevel($skill->level);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProficiencyLevel($level = null)
    {
        $level = $level ?: $this->level;
        
        if ($level >= 80) return 'expert';
        if ($level >= 60) return 'advanced';
        if ($level >= 40) return 'intermediate';
        return 'beginner';
    }

    public function getCategoryName()
    {
        return ucfirst($this->proficiency);
    }

    public function getCategoryClass()
    {
        switch ($this->proficiency) {
            case 'expert': return 'primary';
            case 'advanced': return 'success';
            case 'intermediate': return 'info';
            case 'beginner': return 'warning';
            default: return 'secondary';
        }
    }

    /**
     * Scope a query to only include skills for the current user.
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function projects()
{
    return $this->belongsToMany(Project::class, 'project_skill', 'skill_id', 'project_id')
                ->withTimestamps();
}

}