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

    // Jika ingin cast datetime / lain-lain:
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed', // optional: aktifkan hanya jika ingin auto-hash when setting $user->password = 'plain'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
