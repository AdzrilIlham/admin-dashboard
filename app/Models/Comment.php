<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'name', 'email', 'comment', 'parent_id', 'is_admin'
    ];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
