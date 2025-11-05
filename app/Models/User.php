<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One-to-Many: User memiliki banyak Projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Relasi One-to-Many: User memiliki banyak Skills
     */
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Relasi One-to-Many: User memiliki banyak Visitors (jika ada)
     */
    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}