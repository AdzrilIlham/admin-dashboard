<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    // Daftar kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'proficiency', // tingkat keahlian
        'icon',
        'description',
        'level', // jika masih ingin dipakai juga
    ];
}
