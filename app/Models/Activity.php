<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'activity_type_id',
        'title',
        'description',
        'image',
        'date'
    ];
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
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function activityType()
    {
        return $this->belongsTo(ActivitiesType::class);
    }
    //Deleted observer
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($activity) {
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
        });
    }


}
