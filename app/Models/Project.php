<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'image', 'link', 'status']; // Tambah user_id
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}