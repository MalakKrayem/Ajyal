<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'details',
        'image',
        'notes',
        'attachment',
        'deadline',
        'status',
    ];

    //Local Scope
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
