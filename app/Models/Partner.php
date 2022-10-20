<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','logo'];
    protected $hidden = ['created_at','updated_at'];

    public function getlogoUrlAttribute()
    {
        if (!$this->logo) {
            return 'https://img.favpng.com/2/12/12/computer-icons-portable-network-graphics-user-profile-avatar-png-favpng-L1ihcbxsHbnBKBvjjfBMFGbb7.jpg';
        }
        if(Str::startsWith($this->logo, ['http://', 'https://']) ) {
            return $this->logo;
        }

        return asset('storage/' . $this->logo);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_partner')->withDefault();
    }

    //Delete Observer
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($partner) {
            if($partner->logo){
                Storage::disk('public')->delete($partner->logo);
            }
        });
    }

}
