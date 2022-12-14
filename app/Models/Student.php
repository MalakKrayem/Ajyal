<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable=[
        'first_name',
        'last_name',
        'email',
        'password',
        'image',
        'phone',
        'address',
        'gender',
        'rate',
        'transport',
        'status',
        'total_income',
        'total_jobs',
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

    public function groups(){
        return $this->belongsToMany(Group::class,'student_group');
    }
    public function attendences()
    {
        return $this->hasMany(Attendence::class, 'student_id', 'id')->withDefault();
    }
    public function freelances()
    {
        return $this->hasMany(Freelance::class)->withDefault();
    }

    //Relation with rate
    public function rates()
    {
        return $this->hasMany(Rate::class)->withDefault();
    }
}