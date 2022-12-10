<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\AchievementAdded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mentor extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'image',
        'overview'

    ];
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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

    //Delete Observer
    public static function booted()
    {
        static::deleted(function ($mentor) {
            if($mentor->image){
                Storage::disk('public')->delete($mentor->image);
            }
        });
    }

    //Relation with courses
    public function courses()
    {
        return $this->hasMany(Course::class)->withDefault();
    }

}