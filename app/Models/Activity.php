<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
