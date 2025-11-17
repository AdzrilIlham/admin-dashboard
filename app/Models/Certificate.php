<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'portfolio_id',
        'title',
        'issuer',
        'issued_at',
        'certificate_file'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
