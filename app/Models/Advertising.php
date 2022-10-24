<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
    public function getAttachmentUrlAttribute()
    {

        return asset('storage/' . $this->attachment);
    }

    //Deleted observer
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($advertising) {
            if ($advertising->image) {
                Storage::disk('public')->delete($advertising->image);
            }
        });
    }
}
