<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory; 

    // daftar kolom yang bisa diisi mass assignment
    protected $fillable = ['name', 'level'];
}
