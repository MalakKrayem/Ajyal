<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = ['name','job_count','image'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://img.favpng.com/2/12/12/computer-icons-portable-network-graphics-user-profile-avatar-png-favpng-L1ihcbxsHbnBKBvjjfBMFGbb7.jpg';
        }
        if(Str::startsWith($this->image, ['http://', 'https://']) ) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    //Deleted observer
    protected static function booted()
    {
        static::deleted(function ($platform) {
            if ($platform->image) {
                Storage::disk('public')->delete($platform->image);
            }
        });
    }

    //Relationship with Freelance
    public function freelances()
    {
        return $this->hasMany(Freelance::class)->withDefault();
    }
}
