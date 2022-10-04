<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://img.favpng.com/2/12/12/computer-icons-portable-network-graphics-user-profile-avatar-png-favpng-L1ihcbxsHbnBKBvjjfBMFGbb7.jpg';
        }

        return asset('storage/' . $this->image);
    }
}
