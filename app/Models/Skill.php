<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['user_id', 'name', 'level', 'category']; // Tambah user_id
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}